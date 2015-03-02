Feature: cart
  In order to use the cart
  As a visitor
  I need to be able to add products into it

  @cart
  Scenario: See an empty cart
    Given I am on "/cart"
    Then I should see "Tu carrito está vacío"

  @cart
  Scenario: Add a product
    Given I am on "/cart/product/10/add"
    Then I should be on "/cart"
    Then I should see "I was there II Spanish"
    Then I should see "11,90 $"

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