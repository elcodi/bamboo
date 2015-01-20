@product
Feature: product page
  In order to see the product page properly
  As an anonymous user
  I need to be able to see some elements in the product page

  @view
  Scenario: View the product name
    Given I am on the product 1 page
    Then I should see product 1 name