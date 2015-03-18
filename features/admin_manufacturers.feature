Feature: admin
  In order to admin my manufacturers
  As an admin
  I need to be able to see all manufacturer views

  @admin @manufacturer
  Scenario: See manufacturer list in admin with new manufacturer element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "/admin/manufacturers"
    Then the response should contain "manufacturer-1"
    Then the response should contain "new-manufacturer"
