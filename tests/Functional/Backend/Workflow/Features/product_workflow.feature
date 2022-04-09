# ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=backend_workflow

# Nos hará falta @javascript, ya que el formulario tiene funcionalidades en Javascript
# Tendremos que levantar selenium
@javascript
Feature: Product Workflow
  In order to offer a user a new product
  As an admin user
  I should be able to create a product in the backend and then make it visible to everyone

  Scenario: Initialize Scenario and check no products are found
    Given I go to "http://test.cursotesting.local:81/products"
    Then  I should see "No products found :("

  # Con Ignore Data Fixtures indicamos que no hace falta "hidratar" la base de datos de nuevo.
  @IGNORE_DATA_FIXTURES
  Scenario: Add a product from backend and list it in frontend
    Given I go to "http://test.cursotesting.local:81/sign-in"
    And   I fill in "Email" with "admin@admin.admin"
    And   I fill in "Password" with "admin"
    When  I press "Sign in"
    # COMPROBAMOS TEXTO
    Then  I should see "Welcome admin to the Backend Dashboard"
    # COMPROBAMOS HTML
    Then  the response should contain "Welcome <b>admin</b> to the Backend Dashboard"

    # Con esta opción tenemos desplegado el menú, sino tendríamos que hacer clic sobre el menú hamburguesa
    # And   I navigate from a desktop browser
    # O Creamos un CREAR: CUSTOM STEP DEFINTION
    And   I navigate from a tablet device
    And   I press on the Navigation Toggler

    When  I follow "Products"

    Then  I should see "ProductEntity"
    And   I should see "No results found."
    When  I follow "Add ProductEntity"
    Then  I should see "Create ProductEntity"

    And   I fill in "Name" with "The Delta force"

    # No funciona, puesto que es un WYSIWYG => CREAR: CUSTOM STEP DEFINTION
    # And   I fill in "Description" with "TA film about terrorists and airplane hijacking"
    And   I fill the WYSIWYG "Description" with "A film about terrorists and airplane hijacking"
    And   I fill in "Price" with "55"
    And   I enable product

    # Falla, puesto que no es un select normal
    # And   I select "action" from "Category"
    And   I choose "action" from "Category"

    And   I press "Create"

    And   print current URL
    And   I should see 1 row
    And   I should see "The Delta force" for the column "Name" in the row 1
    And   I should see "55.00" for the column "Price" in the row 1
    # Comprobar el campo enabled en este caso es, complicado, vamos a comprobar que se ha guardado bien en el siguiente escenario

  # DIVIDIR LOS CHECKS EN ESCENARIOS DENTRO DE LA MISMA FEATURE NOS FACILITA IR MÁS RÁPIDO EN EL DESARROLLO DEL TESTING
  # Y EN EL CASO DE FALLOS FUTUROS TRABAJAR MÁS CÓMODAMENTE

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=backend_workflow --tags=CHECK_PRODUCT_IN_DATABASE
  @IGNORE_DATA_FIXTURES
  @CHECK_PRODUCT_IN_DATABASE
  Scenario: Check product is saved properly into database

    # Dos técnicas:
    # - Last Inserted Product (desacoplamiento, recomendado)
    # - Comprobación directa en base de datos (acomplamiendo)
    Then   Product should be saved properly into database

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=backend_workflow --tags=CHECK_PRODUCT_VIA_LAST_PAGE
  @IGNORE_DATA_FIXTURES
  @CHECK_PRODUCT_VIA_LAST_PAGE
  Scenario: Check product is saved properly via last page

    Given I go to "http://test.cursotesting.local:81/try-out/backend/last-insert-product"
    Then  I should see the field "Name:" with the value "The Delta force"
    And   I should see the field "Description:" with the value "<div>A film about terrorists and airplane hijacking</div>"
    And   I should see the field "Price:" with the value "55.00"
    And   I should see the field "State:" with the value "yes"

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=backend_workflow --tags=CHECK_PRODUCT_DISPLAYED_PROPERLY_IN_THE_FRONTEND
  @IGNORE_DATA_FIXTURES
  @CHECK_PRODUCT_DISPLAYED_PROPERLY_IN_THE_FRONTEND
  Scenario: Check product is displayed properly in the frontend
    When  I go to homepage
    And   I navigate from a desktop browser
    And   I follow "Products"
    Then  I should see "The Delta force"
    Then  I should see "<div>A film about terrorists and airplane hijacking</div>"
    Then  I should see "Category: action"
    Then  I should see "Price: 55.00€"
