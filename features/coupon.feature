Feature: coupon
  In order to use my coupons
  As a visitor
  I need to be able to apply them and remove them

  @login
  Scenario: Enter the admin with no credentials
    Given I am on "/cart"
    Then I should see "Your cart is empty"