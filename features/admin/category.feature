@admin @category
Feature: Admin category
  In order to categorize my products
  As an admin
  I need to be able to see all category views

  Scenario: See category list in admin with new category element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/categories"
    Then the response should contain a "category-1" test attribute
    And the response should contain a "category-2" test attribute
    And the response should contain a "new-category" test attribute

  Scenario: Remove category with products
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/category/1/delete"
    And I go to "/admin/categories"
    Then the response should not contain a "category-1" test attribute
