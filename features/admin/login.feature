@admin @login
Feature: Admin login
  In order to access into the admin zone
  As an anonymous user
  I need to be able to login

  Scenario: Access admin from root
    Given I am on "/admin"
    Then I should be on "/admin/login"
    And the response status code should be 200

  Scenario: Access login form
    Given I am on "/admin/logout"
    When I go to "/admin/login"
    Then the response status code should be 200

  Scenario: User can login
    Given I am on "/admin/login"
    When I fill in the following:
      | elcodi_admin_user_form_type_login_email    | admin@admin.com |
      | elcodi_admin_user_form_type_login_password | 1234            |
    And I press "submit-login"
    Then the response should contain a "admin-menu" test attribute
    And the response should contain "admin@admin.com"

  Scenario: Logged user is redirected to home when goes to login page
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/login"
    Then I should be on "/admin/"

  Scenario: Logged user should be able to change password
    Given In admin, I am logged as "admin@admin.com" - "1234"
    Then I follow "Profile"
    When I fill in the following:
      | elcodi_admin_user_form_type_admin_user_password            | 1234 |
      | elcodi_admin_user_form_type_admin_user_new_password_first  | bar  |
      | elcodi_admin_user_form_type_admin_user_new_password_second | bar  |
    And I press "Save"
    Then I go to "/admin/logout"
    Then I go to "/admin/login"
    When I fill in the following:
      | elcodi_admin_user_form_type_login_email    | admin@admin.com |
      | elcodi_admin_user_form_type_login_password | bar             |
    And I press "submit-login"
    Then I should be on "/admin/"
