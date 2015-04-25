@store @address
Feature: Store address management
  In order to manage my addresses in a secure way
  As a visitor or logged user
  I need to be able to manage them if I have credentials

  Scenario: See my addresses as a non-logged user
    Given I am on "/logout"
    When I am on "/my-addresses"
    Then I am on "/login"

  Scenario: Create a new address as a non-logged user
    Given I am on "/logout"
    When I am on "/my-address/new"
    Then I am on "/login"

  Scenario: Delete as a non-logged user
    Given I am on "/logout"
    When I am on "/my-address/1/remove"
    Then I am on "/login"

  Scenario: See my addresses as a logged user
    Given I am logged as "customer@customer.com" - "1234"
    When I am on "/my-addresses"
    Then the page contains a "address-1" test attribute
    Then the page contains a "address-2" test attribute

  Scenario: I can remove my addresses as a logged user
    Given I am logged as "customer@customer.com" - "1234"
    When I am on "/my-addresses"
    When I am on "/my-address/1/remove"
    Then I am on "/my-addresses"
    And the page does not contain a "address-1" test attribute
    When I am on "/my-address/2/remove"
    Then I am on "/my-addresses"
    And the page does not contain a "address-2" test attribute
    And the page contains a "empty-addresses-page" test attribute
    And the page contains a "add-address" test attribute

  Scenario: I can add a new address as a logged user
    Given I am logged as "customer@customer.com" - "1234"
    Given I remove address "1" from my account
    Given I remove address "2" from my account
    When I am on "/my-address/new"
    And I fill in "store_geo_form_type_address_name" with "my new address"
    And I fill in "store_geo_form_type_address_recipientName" with "Marc"
    And I fill in "store_geo_form_type_address_recipientSurname" with "Morera"
    And I fill in "store_geo_form_type_address_address" with "Carrer Valencia 333"
    And I fill in "store_geo_form_type_address_addressMore" with "Elcodi HQ"
    And I fill in "store_geo_form_type_address_postalcode" with "08009"
    And I fill hidden field "store_geo_form_type_address_city" with "ES_CT_B_Barcelona"
    And I fill in "store_geo_form_type_address_phone" with "123456789"
    And I fill in "store_geo_form_type_address_mobile" with "123456789"
    And I fill in "store_geo_form_type_address_comments" with "Some comments"
    And I press "store_geo_form_type_address_send"
    Then I am on "/my-addresses"
    Then the page contains a "address-3" test attribute

  Scenario: I cannot see an address that is not mine
    Given I am logged as "another-customer@customer.com" - "1234"
    When I am on "/my-address/1"
    Then the response status code should be 404

  Scenario: I cannot edit an address that is not mine
    Given I am logged as "another-customer@customer.com" - "1234"
    When I am on "/my-address/1/edit"
    Then the response status code should be 404

  Scenario: I cannot remove an address that is not mine
    Given I am logged as "another-customer@customer.com" - "1234"
    When I am on "/my-address/1/remove"
    Then the response status code should be 404