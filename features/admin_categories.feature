Feature: admin
  In order to categories my products
  As an admin
  I need to be able to see all category views

  @admin @category
  Scenario: See category list in admin with new category element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "/admin/categories"
    Then I should see "Hombre"
    And I should see "Nueva categoría"

  @admin @category
  Scenario: Remove category with products
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "http://localhost:8000/admin/category/1/delete"