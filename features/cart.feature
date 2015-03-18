Feature: cart
  In order to use the cart
  As a visitor
  I need to be able to add products into it

  @cart
  Scenario: See an empty cart
    Given I am on "/cart"
    Then the response should contain "empty-cart"

  @cart
  Scenario: Add a product
    Given I am on "/cart/product/10/add"
    Then print last response
    Then I should be on "/cart"
    Then the response should not contain "empty-cart"

  @cart
  Scenario: See the cart checkout without being logged in
    Given I am on "/cart/product/10/add"
    When I am on "/checkout/payment"
    Then I should be on "/login"

  @cart
  Scenario: See the cart checkout being logged in
    Given I am logged as "customer@customer.com" - "1234"
    And I am on "/cart/product/10/add"
    When I go to "/checkout/payment"
    Then I should be on "/checkout/address"