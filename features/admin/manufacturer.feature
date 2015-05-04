@admin @manufacturer
Feature: Admin manufacturer
  In order to manage my manufacturers
  As an admin
  I need to be able to see all manufacturer views

  Scenario: See manufacturer list in admin with new manufacturer element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/manufacturers"
    Then the response should contain a "manufacturer-1" test attribute
    And the response should contain a "new-manufacturer" test attribute
