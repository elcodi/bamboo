Feature: admin
  In order to admin my manufacturers
  As an admin
  I need to be able to see all manufacturer views

  @admin @manufacturer
  Scenario: See manufacturer list in admin with new manufacturer element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "/admin/manufacturers"
    Then I should see "Levis"
    And I should see "New manufacturer"
