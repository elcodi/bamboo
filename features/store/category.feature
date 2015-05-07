@store @category
Feature: Store category
  In order to see the category page properly
  As an anonymous user
  I need to be able to see some elements in the category page

  Scenario: View the category name
    Given I am on "category/women-shirts/1"
    Then I should see more than 0 products

  Scenario: Category redirection
    Given I am on "category/women-shirts-false/1"
    Then I should be on "category/women-shirts/1"