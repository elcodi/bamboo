Feature: admin
  In order to categories my products
  As an admin
  I need to be able to see all category views

  @admin @category
  Scenario: See category list in admin with new category element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "/admin/categories"
    Then the response should contain "category-1"
    Then the response should contain "category-2"
    Then the response should contain "new-category"

  @admin @category
  Scenario: Remove category with products
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "http://localhost:8000/admin/category/1/delete"