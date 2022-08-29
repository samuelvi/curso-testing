# ./vendor/bin/behat --config=tests/Functional/behat.yaml --suite=frontend_routing --tags=ROUTING_TABLE --tags=FRONTEND
# ./vendor/bin/behat --config=tests/Functional/behat.yaml tests/Functional/Frontend/Routing/Features/frontend.table.feature
@FRONTEND
@ROUTING_TABLE
@TABLE
#@javascript
Feature: Public web navigation via scenario outline table
  In order to visit the public web site
  As an anonymous user
  I should be able to navigate through out all the frontend sections from a given table of information

  # ./vendor/bin/behat --config app/config/behat.yml tests/Functional/Routing/Features/frontend.table.feature --tags=ONE_LEVEL_ROUTES
  @ONE_LEVEL_ROUTES
  Scenario Outline:
    Given I go to the homepage
    When  I follow <section>
    Then  the url should match <url>
    And   I should see <text>

    Examples:
      | section                    | url                     | text                                    |
      | "Home Page"                | "/"                     | "Welcome to Curso Testing demo website" |
      | "Contact"                  | "/contact"              | "You are here: Contact Form"            |
      | "Products"                 | "/products"             | "You are here: List of Products"        |
      # | "Sign in"  => la "i" de "in" en minúsculas hará que peten los test
      | "Sign In"                  | "/sign-in"              | "You are here: Sign in Form"            |
      # Cookies Policy, sin la palabra "Legal" delante también funcionará
      | "Legal Cookies Policy"     | "/cookies"              | "You are here: Cookies"                 |
      | "Legal Terms & Conditions" | "/terms-and-conditions" | "You are here: Terms and Conditions"    |


  # ./vendor/bin/behat --config app/config/behat.yml tests/Functional/Routing/Features/frontend.table.feature --tags=SIGN_IN_OPTIONS
  @SIGN_IN_OPTIONS
  Scenario Outline:
    When  I go to "/sign-in"
    And   I follow <section>
    Then  the url should match <url>
    And   I should see <text>

    Examples:
      | section               | url                       | text                                   |
      | "Forgot password?"    | "/request-reset-password" | "You are here: Request reset password" |
      | "New User? Register!" | "/registration"           | "You are here: Registration Form"      |
    
