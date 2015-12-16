@store @cart
Feature: Store cart
  In order to use the cart
  As a visitor or logged user
  I need to be able to add products into it and access the checkout

  Scenario: See an empty cart
    Given I am on "/cart"
    Then the response should contain a "empty-cart" test attribute

  Scenario: Add a product
    Given I am on "/cart/purchasable/10/add"
    Then I should be on "/cart"
    And the response should not contain a "empty-cart" test attribute

  Scenario: See the cart checkout without being logged in
    Given I am on "/cart/product/10/add"
    When I go to "/cart/address"
    And I should be on "/login"

  Scenario: See the cart checkout being logged in
    Given I am logged as "customer@customer.com" - "1234"
    When I go to "/cart/product/10/add"
    And I go to "/cart/address"
    Then I should be on "/cart/address"
