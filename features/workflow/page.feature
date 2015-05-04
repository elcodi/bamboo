@workflow @page
Feature: Workflow pages
  In order to make the pages engine work
  As an admin user
  I need to be able to create a page from admin panel, and view it in store

  Scenario: Create a page
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/page/new"
    And I fill in the following:
      | elcodi_admin_page_form_type_page_title_en_title     | My testing page |
      | elcodi_admin_page_form_type_page_path_en_path       | my-testing-page |
      | elcodi_admin_page_form_type_page_content_en_content | This is my page |
    And I press "submit-page"
    And I am on "/page/9/my-testing-page"
    Then I should see "My testing page"
    And I should see "This is my page"

  Scenario: Disable a page
    Given I am on "/page/3/terms-and-conditions"
    And the response status code should be 200
    And In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/page/3"
    And I uncheck "elcodi_admin_page_form_type_page[enabled]"
    And I press "submit-page"
    And I am on "/page/3/terms-and-conditions"
    Then the response status code should be 404

  Scenario: Delete a page
    Given I am on "/page/3/terms-and-conditions"
    And the response status code should be 200
    And In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/page/3/delete"
    And I go to "/page/3/terms-and-conditions"
    Then the response status code should be 404