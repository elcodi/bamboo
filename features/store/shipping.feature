@store @shipping
Feature:
  In order to have good shipping information
  as a logged user
  I need to see correct shipping values

  Scenario: Free shipping
    Given I have an empty cart
    When I add product "2" in my cart
    And I am in the "cart" path
