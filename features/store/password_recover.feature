@store @password
Feature: Store password recover
  In order to access the customer zone
  As an anonymous user
  I need to be able to recover my password

  Scenario: Access recover my password
    Given I am on "/password/remember"
    Then the response status code should be 200
