@store @registration
Feature: Store registration
  In order to become a customer
  As an anonymous user
  I need to register

  Scenario: Access register form
    Given I am on "/register"
    Then the response status code should be 200

  Scenario: User can register itself
    Given I am on "/register"
    When I fill in the following:
      | store_user_form_type_register_firstname       | John              |
      | store_user_form_type_register_lastName        | Doe               |
      | store_user_form_type_register_email           | john-doe@mail.com |
      | store_user_form_type_register_password_first  | 1234              |
      | store_user_form_type_register_password_second | 1234              |
    And I press "store_user_form_type_register_send"
    Then the response should contain a "logged-username" test attribute
    And the response should contain "John"

  Scenario: Logged user is redirected to home when goes to register page
    Given I am logged as "customer@customer.com" - "1234"
    When I go to "/register"
    Then I should be on "/"