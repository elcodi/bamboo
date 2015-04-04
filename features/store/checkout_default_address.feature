@store @checkout @address
Feature: Checkout default address
  In order to have a default address
  As a logged user
  If I don't have addresses and I add a new one, this address should be used as
  my address, so it's not necessary to select what address i want to use and you
  can send me to the payment step

  Scenario: Default behavior
    Given I am logged as "customer@customer.com" - "1234"