# ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=CONTACT_FORM_OK
@CONTACT_FORM_OK
@FRONTEND
Feature: Check that users can contact us from the contact form
  In order for users to contact us
  As an anonymous or logged user
  I complete and send a contact form request

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=OK
  @OK
  Scenario: Send a contact form request

    # Vamos directamente a la url. El testing del routing y que estamos en la página correcta ya lo tenemos cubierto
    Given I go to "http://test.cursotesting.local/contact"

    When I fill in "Full name" with "Wendy Wolf"
    And  I fill in "E-mail" with "wendywolf@minkbehat.com"
    And  I fill in "Subject" with "Need help on BDD"
    And  I fill in "Message" with "Can you help me on BDD please?"

    And  I check "Accept terms and conditions"
    And  I press "Send Contact Form Request"

    Then I should see "You are here: Contact Form managed Successfully"

  # ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_contact_form --tags=EMAIL
  @EMAIL
  Scenario: Check 2 e-mails are sent when contact form request submission

    Given I go to "http://test.cursotesting.local/contact"

    # Inicialización del inbox a 0. En otro caso se irán acumulando y en algún punto fallarán los tests
    And my inbox is empty

    # Custom Step Definitions. Will find by label, placeholder and input name
    When I type "Wendy Wolf" in "Full name"
    And  I type "wendywolf@minkbehat.com" in "E-mail"
    And  I type "Help me with BDD or die" in "Subject"

    And  I fill in "Message" with "Can you help me on BDD please?"
    And  I check "Accept terms and conditions"

    When I submit the contact form

    # Para comprobarlo visualmente: http://localhost:8026/
    # Para visualizar los step definitions de MailhogExtension:
    # ./vendor/bin/behat --config=tests/Functional/behat.yaml -dl | grep email
    And  there should be 2 emails in my inbox
    And  I should see an email with subject "A user contacted Us! (Wendy Wolf)"
    And  I should see an email with subject "Thank you Wendy Wolf for contacting Us!"
    And  I should see an email with body "This is copy of your contact form"

    # Podemos mejorarlo tal que así:
    And  there should be 2 emails in my inbox
    And  I should see an email with subject "A user contacted Us! (Wendy Wolf)" and body "This is copy of your contact form" from "webmaster@email.ext" to "webmaster@email.ext"
    And  I should see an email with subject "Thank you Wendy Wolf for contacting Us!" and body "This is copy of your contact form" from "webmaster@email.ext" to "wendywolf@minkbehat.com"

