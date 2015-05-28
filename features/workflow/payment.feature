@workflow @payment
Feature: Test payment
  In order to be sure any user can buy a product
  As a logged user
  I need to be able to buy products using coupons and check created order

  @javascript
  Scenario: Payment workflow with stripe
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/plugins"
    And I check "enable-plugin-887ee51dc5572759c418db09b66988664f0ecbc1"
    And I follow "/admin/plugin/887ee51dc5572759c418db09b66988664f0ecbc1"
    And I fill in the following:
      | elcodi_form_type_plugin_private_key | sk_test_WccEP1bzQJRowjtsx2R65hr3 |
      | elcodi_form_type_plugin_public_key  | pk_test_6937Di9YMLplqWr6HaQIGdLI |
    And I press "elcodi_form_type_plugin_save"
    And I am logged as "customer@customer.com" - "1234"
    And I go to "/cart/product/2/add"
    And I follow "Checkout"
    And I follow "Payment"
    And I follow "test-payment-887ee51dc5572759c418db09b66988664f0ecbc1"
    And I fill in the following:
      | stripe_view_credit_cart                  | 4242424242424242 |
      | stripe_view_credit_cart_security         | 123              |
      | stripe_view_credit_cart_expiration_month | 19               |
      | stripe_view_credit_cart_expiration_year  | 2020             |
    And I press "payment-submit"
    Then I should be on "/order/2/thanks"