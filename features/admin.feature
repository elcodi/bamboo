Feature: admin
  In order to access the admin interface
  As a visitor
  I need to be able to log in to the website

  @admin @login
  Scenario: Enter the admin with no credentials
    Given I am on "/admin/"
    Then I should be on "/admin/login"

  @admin @login
  Scenario: Enter the admin with no credentials
    Given I am on "/admin/"
    When I fill in the following:
      | elcodi_admin_user_form_type_login_email    | admin@admin.com |
      | elcodi_admin_user_form_type_login_password | 1234            |
     And I press "Log In"
    Then I should be on "/admin/"
     And I should see "Elcodi Admin"
