@store @homepage
Feature: Store homepage
  In order to see the homepage properly
  As an anonymous user
  I need to be able to see some elements in the homepage

  Scenario: List some products in the homepage
    Given I am on the homepage
    Then I should see more than 0 products

  Scenario: List root categories in the homepage
    Given I am on the homepage
    Then I should see category menu item
      | name    | active |
      | New     | true   |
      | Women's | false  |
      | Men's   | false  |
