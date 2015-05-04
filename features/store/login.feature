@store @login
Feature: Store login
  In order to access into the customers zone
  As an anonymous user
  I need to be able to login

  Scenario: Access login form
    Given I am on "/logout"
    And I go to "/login"
    Then the response status code should be 200

  Scenario: User can login
    Given I am on "/login"
    When I fill in the following:
      | store_user_form_type_login_email    | customer@customer.com |
      | store_user_form_type_login_password | 1234                  |
    And I press "store_user_form_type_login_send"
    Then the response should contain a "logged-username" test attribute
    And the response should contain "Homer"

  Scenario: Logged user is redirected to home when goes to login page
    Given I am logged as "customer@customer.com" - "1234"
    When I go to "/login"
    Then I should be on "/"
