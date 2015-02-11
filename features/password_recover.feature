@store @password @view
Feature: password recover
  In order to access the customer zone
  As an anonymous user
  I need to be able to recover my password

  Scenario: Access recover my password
    Given I am on "/password/remember"
    Then I should see "Recover password"
