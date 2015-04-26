@store @notfound
Feature: Store not found page
  In order to navigate
  As a user
  I want to be notified when a url does not exist

  Scenario: 404 page
    Given I am on "/this-page-should-not-be-found"
    Then the response status code should be 404
