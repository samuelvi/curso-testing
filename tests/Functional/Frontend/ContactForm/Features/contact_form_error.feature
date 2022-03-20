# ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=CONTACT_FORM_ERROR

@CONTACT_FORM_ERROR
Feature: Check that users can not contact us from the contact form
  In order for users to contact us
  As an anonymous user
  I am not be able to complete and send a contact form request

  Background:
    # Vamos directamente a la url. El testing del routing y que estamos en la página correcta ya lo tenemos cubierto
    Given I go to "http://test.cursotesting.local/contact"
    # Hacemos que quepa el formulario en la pantalla, de otro modo el botón de envío de formulario de contacto no será clicable
    And   I navigate from a desktop browser
    # Inicializamos inbox a vacío
    And   my inbox is empty

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=CONTACT_FORM_ERROR --tags=EMPTY_FIELDS --tags=~JAVASCRIPT_VALIDATION
  @EMPTY_FIELDS
  Scenario: Check validation for empty fields
    And  I press "Send Contact Form Request"
    Then I should see "The full name can not be empty"
    And  I should see "The e-mail can not be empty"
    And  I should see "Message subject required"
    And  I should see "Message required"
    And  I should see "You must accept terms and conditions"

    # CUSTOM STEP DEFINITION
    And  I should see an error message next to "The e-mail can not be empty"

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=CONTACT_FORM_ERROR --tags=EMAIL_NOT_VALID
  @EMAIL_NOT_VALID
  Scenario: Check validation for e-mail not valid
    And  I fill in "E-mail" with "this-is-not-a-valid-e-mail-address"
    And  I press "Send Contact Form Request"
    Then I should see "The given e-mail is not valid"

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=CONTACT_FORM_ERROR --tags=EMPTY_FIELDS --tags=JAVASCRIPT_VALIDATION
  @JAVASCRIPT_VALIDATION
  @EMPTY_FIELDS
  # IMPORTANTE ACTIVAR JAVASCRIPT
  @javascript
  Scenario: Check validation for empty fields
    When I enable javascript validation
    And  I press "Send Contact Form Request"
    Then I should see "Full name required"
    And  I should see "E-mail required"
    And  I should see "Subject required"
    And  I should see "Message required"
    And  I should see "Must accept terms and conditions"
    And  there should be 0 emails in my inbox

    When  I fill in "E-mail" with "this-is-not-a-valid-e-mail-address"
    # Hacemos scroll hasta el botón, sino peta el javascript.
    # Este Step Definition es bastante complejo. Ver el código fuente!
    And  I scroll to "Send Contact Form Request"
    # Comprobar como con un pantallazo si que se ve que ha hecho scroll
    # And  I take a screenshot "scrolled-page"

    And  I press "Send Contact Form Request"
    And  I should see "E-mail not valid"
    And  I should see "Full name required" only once

    # Rellenamos todos los valores requeridos excepto uno, para poder comprobar que los mensajes de error han desaparecido
    When I fill in "Full name" with "Wendy Wolf"
    And  I fill in "Subject" with "Need help on BDD"
    And  I fill in "Message" with "Can you help me on BDD please?"
    And  I check "Accept terms and conditions"
    And  I press "Send Contact Form Request"

    # Ojo. Es "NOT see". Necesitamos que todos los campos sean válidos excepto 1,
    # para comprobar que se ejecutan las validaciones Javascript, pero no se hace el post al controller
    And  I should not see "Full name required"
    And  I should not see "Subject required"
    And  I should not see "Message required"
    And  I should not see "Must accept terms and conditions"
    And  I should see "E-mail not valid"

    #Ahora comprobamos que el error de e-mail desaparece
    When I fill in "Full name" with ""
    And  I fill in "E-mail" with "wendywolf@minkbehat.com"
    And  I should not see "E-mail required"
