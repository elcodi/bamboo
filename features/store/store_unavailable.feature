@store @unavailable
Feature: Store is unavailable
  In order to block the store
  As an administrator
  I need to be able to mark it "disabled" or "under construction"

  Scenario: Store is disabled
    Given the store is disabled
    When I am on "/"
    Then the response status code should be 503

  Scenario: Store is under construction
    Given the store is under construction
    When I am on "/"
    Then the response status code should be 503
