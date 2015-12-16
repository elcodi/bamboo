@store @coupon
Feature: Store coupon
  In order to use my coupons
  As a visitor
  I need to be able to apply them and remove them

  Scenario: Can't apply a coupon on an empty cart
    Given I am on "/cart"
    Then the response should contain a "empty-cart" test attribute
    And the response should not contain a "coupon-add" test attribute

  Scenario: Apply a coupon
    Given I am on "/cart/purchasable/10/add"
    When I go to "/cart"
    And the page does not contain a "coupon-item" test attribute
    And I fill in "store_cart_coupon_form_type_coupon_apply_code" with "5euros"
    And I press "store_cart_coupon_form_type_coupon_apply_apply"
    Then I should be on "/cart"
    And the response should contain a "coupon-item" test attribute
    And the response should contain "-$6.78"

  Scenario: Remove a coupon
    Given I am on "/cart/purchasable/10/add"
    When I go to "/cart"
    And I fill in "store_cart_coupon_form_type_coupon_apply_code" with "5euros"
    And I press "store_cart_coupon_form_type_coupon_apply_apply"
    And the page contains a "coupon-item" test attribute
    And I go to "/cart/coupon/remove/5euros"
    Then I should be on "/cart"
    And the response should not contain a "coupon-item" test attribute
