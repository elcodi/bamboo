@store
Feature: Url does not exist
  In order to navigate
  As a user
  I want to be notified when a url does not exist

  @view
  Scenario: 404 page
    Given I am on "/this-page-should-not-be-found"
    Then the response status code should be 404
     And I should see "404 Page not found"
