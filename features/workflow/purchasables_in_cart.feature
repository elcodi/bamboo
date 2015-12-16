@workflow @purchasable @cart
Feature: Purchasable in cart
  In order to be able to buy purchasabes
  As an admin user
  I need to be able to buy purchasables

  Scenario: Buy purchasables
    Given I am logged as "customer@customer.com" - "1234"
    And I go to "/cart/purchasable/2/add"
    And I go to "/cart/purchasable/6/add"
    And I go to "/cart/purchasable/23/add"
    And I follow "Checkout"
    And I press "Payment"
    When I go to "/cart/payment"
    When I go to "/payment/freepayment/execute"
    Then I should be on "/order/1/thanks"
    And I should see purchasable 2 name
    And I should see purchasable 6 name
    And I should see purchasable 23 name
    And I should see "58.68"