# ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=backend_workflow

Feature: Product Workflow
  In order to offer a user a new product
  As an admin user
  I should be able to create a product in the backend and then make it visible to everyone

  Scenario: Initialize Scenario and check no products are found
    Given I go to "http://test.cursotesting.local/products"
    Then  I should see "No products found :("

  # Con Ignore Data Fixtures indicamos que no hace falta "hidratar" la base de datos de nuevo.
  @IGNORE_DATA_FIXTURES
  Scenario: Add a product from backend and list it in frontend
    Given I go to "http://test.cursotesting.local/sign-in"
    And   I fill in "Email" with "admin@admin.admin"
    And   I fill in "Password" with "admin"
    When  I press "Sign in"
    # COMPROBAMOS TEXTO
    Then  I should see "Welcome admin to the Backend Dashboard"
    # COMPROBAMOS HTML
    Then  the response should contain "Welcome <b>admin</b> to the Backend Dashboard"

    When  I follow "Products"
    Then  I should see "ProductEntity"
    And   I should see "No results found."
    When   I follow "Add ProductEntity"
#    Then  I should see "Create Product"
#    And   I fill in "Name" with "The Delta force"
#    And   I fill in "Price" with "55"
#    And   I fill in "Description" with "A film about terrorists and airplane hijacking"
#    And   I select "Films" from "Category"
#    And   I press "Save changes"
#    When  I go to homepage
#    And   I follow "List Products"
#    Then  I should see listed first the product with name "The Delta force", price "55.00", category "Films" and description "A film about terrorists and airplane hijacking"
