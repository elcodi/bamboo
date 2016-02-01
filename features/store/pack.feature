@store @pack
Feature: Store pack
  In order to see the pack page properly
  As an anonymous user
  I need to be able to see some elements in the pack page

  Scenario: View the pack name
    Given I am on the product 23 page
    Then I should see pack 23 name
    And the response should contain a "add-pack-23-to-cart" test attribute

  Scenario: Product redirection
    Given I am on "pack/another-url/23"
    Then I should be on "pack/pack-4-flavors-en/23"