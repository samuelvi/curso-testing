# ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_routing --tags=ROUTING --tags=FRONTEND
@FRONTEND
@ROUTING
# @javascript
Feature: Public web navigation
  In order to visit the public web site
  As an anonymous user
  I should be able to navigate throught out all the frontend sections

  # DRY: Background helps us to not repeating duplicated code.
  Background:
    # Must be set up base_url in behat.yaml
    Given I go to the homepage
    # Given I go to "http://test.cursotesting.local"
    And   I navigate from a desktop browser
    # Equivalent: Given I am on homepage
    # Equivalent: Given I am to the homepage

  Scenario: Visit the homepage
    # the html tags are stripped by Mink: <b>Curso Testing</b>
    Then  I should see "Welcome to Curso Testing demo website"

  Scenario: Visit the contact form page
    When  I follow "Contact"
    Then  the url should match "/contact"
    Then  I should see "You are here: Contact Form"

  # Aquí nos petará si no existe la base de datos
  Scenario: Visit the products page
    When  I follow "Products"
    Then  the url should match "/products"
    Then  I should see "You are here: List of Products"

  Scenario: Visit the registration page
    When  I follow "Registration"
    Then  the url should match "/registration"
    Then  I should see "You are here: Registration Form"

  Scenario: Visit the login form page
    When  I follow "Sign In"
    Then  the url should match "/sign-in"
    And   I should see "You are here: Sign in Form"

  Scenario: Visit the request reset password page
    When  I follow "Sign In"
    And   I follow "Forgot password?"
    Then  the url should match "/request-reset-password"
    And   I should see "You are here: Request reset password"

  @LEGAL @COOKIES
  # FALSO POSITIVO. En realidad no se puede hacer clic ya que hay un div por encima que evita el clic sobre el enlace
  # Si usamos Selenium, si que nos petará el test
  Scenario: Visit the legal cookies policy page
    When  I follow "Legal Cookies Policy"
    Then print current URL
