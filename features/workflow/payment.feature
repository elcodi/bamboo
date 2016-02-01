@workflow @payment
Feature: Test payment
  In order to be sure any user can buy a product
  As a logged user
  I need to be able to buy products using coupons and check created order

  @javascript @stripe
  Scenario: Payment workflow with stripe
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/plugins"
    And I uncheck "enable-plugin-887ee51dc5572759c418db09b66988664f0ecbc1"
    And I am logged as "customer@customer.com" - "1234"
    And I go to "/cart/purchasable/6/add"
    And I follow "Checkout"
    And I press "Payment"
    And I should not see "Card number"
    And I go to "/admin/plugins"
    And I check "enable-plugin-887ee51dc5572759c418db09b66988664f0ecbc1"
    And I go to "/admin/plugin/887ee51dc5572759c418db09b66988664f0ecbc1"
    And I fill in the following:
      | elcodi_form_type_plugin_private_key | sk_test_WccEP1bzQJRowjtsx2R65hr3 |
    And I press "elcodi_form_type_plugin_save"
    And I go to "/cart/payment"
    And I should not see "Card number"
    And I go to "/admin/plugins"
    And I check "enable-plugin-887ee51dc5572759c418db09b66988664f0ecbc1"
    And I go to "/admin/plugin/887ee51dc5572759c418db09b66988664f0ecbc1"
    And I fill in the following:
      | elcodi_form_type_plugin_private_key | sk_test_WccEP1bzQJRowjtsx2R65hr3 |
      | elcodi_form_type_plugin_public_key  | pk_test_6937Di9YMLplqWr6HaQIGdLI |
    And I press "elcodi_form_type_plugin_save"
    And I go to "/cart/payment"
    And I should see "Card number"
    And I fill in the following:
      | stripe_view_credit_card                  | 4242424242424242 |
      | stripe_view_credit_card_security         | 123              |
      | stripe_view_credit_card_expiration_month | 12               |
      | stripe_view_credit_card_expiration_year  | 2020             |
    And I press "payment-submit"
    And I should be on "/order/1/thanks"
    And I should see "$5.41"
    And I should see "$12.21"
    And I should see "$17.62"
    And I go to "/my-orders"
    And I should see "Paid"
    And I should see "Preparing"
    And I go to "/admin/orders"
    And the page contains a "order-1" test attribute
    And I should see "$17.62"
    And I should see "Paid"
    And I should see "Preparing"
    And I go to "/admin/order/1"
    And I should see "$5.41"
    And I should see "$12.21"
    And I should see "$17.62"
    And I should see "Paid"
    And I should see "Preparing"
