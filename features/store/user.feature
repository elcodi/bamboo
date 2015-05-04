@store @user
Feature: Store user
  In order to manage my information
  As a logged user
  I need to be able to view and change my information

  Scenario: User management should not be accessible if not logged
    Given I am on "/user"
    Then I should be on "/login"

  Scenario: User should be able to logout
    Given I am logged as "noncustomer@customer.com" - "1234"
    When I go to "/logout"
    Then the response should not contain a "logged-username" test attribute

  Scenario: Wrong login
    Given I am logged as "customer@customer.com" - "wrong-password"
    Then I should be on "/login"
    And the response should contain "message-ko"

  Scenario: User management should be accessible if logged
    Given I am logged as "customer@customer.com" - "1234"
    When I go to "/user"
    Then I should be on "/user"
    And the page contains a "user-dashboard-profile-link" test attribute
    And the page contains a "user-dashboard-orders-link" test attribute
    And the page contains a "user-dashboard-address-link" test attribute

  Scenario: User logged should see its data in edit tab
    Given I am logged as "customer@customer.com" - "1234"
    When I go to "/user/edit"
    Then the "store_user_form_type_profile_firstname" field should contain "Homer"
    And the "store_user_form_type_profile_lastname" field should contain "Simpson"
    And the "store_user_form_type_profile_email" field should contain "customer@customer.com"
    And the "store_user_form_type_profile_password_first" field should not contain "1234"
    And the "store_user_form_type_profile_password_second" field should not contain "1234"

  Scenario: User logged should see its data in all pages
    Given I am logged as "customer@customer.com" - "1234"
    And I am on "/"
    And I should see "Homer"

  Scenario: User logged should be able to change its data
    Given I am logged as "customer@customer.com" - "1234"
    And I go to "/user/edit"
    When I fill in the following:
      | store_user_form_type_profile_firstname | Engonga                 |
      | store_user_form_type_profile_lastname  | Flipencio               |
      | store_user_form_type_profile_email     | engonga@uhsinoseque.com |
    And I press "store_user_form_type_profile_send"
    Then I should be on "/user/edit"
    And the "store_user_form_type_profile_firstname" field should contain "Engonga"
    And the "store_user_form_type_profile_lastname" field should contain "Flipencio"
    And the "store_user_form_type_profile_email" field should contain "engonga@uhsinoseque.com"
