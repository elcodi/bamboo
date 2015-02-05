@store
Feature: store is unavailable
  In order to block the store
  As an administrator
  I need to be able to mark it "disabled" or "under construction"

  @view
  Scenario: Store is disabled
    Given the store is disabled
    When I am on "/"
    Then the response status code should be 503
    Then I should see "Store is disabled"

  @view
  Scenario: Store is under construction
    Given the store is under construction
    When I am on "/"
    Then the response status code should be 503
    Then I should see "Store is under construction"
