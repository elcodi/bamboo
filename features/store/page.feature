@store @page
Feature: Store pages
  In order to see the static pages of my store
  As an anonymous user
  I need to be able to see them all

  Scenario: See an existing page
    Given I am on "/page/2/about-us"
    Then the response status code should be 200

  Scenario: See an existing page but in another language
    Given I am on "/es/page/2/about-us"
    Then I should be on "/es/page/2/sobre-nosotros"
    And the response status code should be 200

  Scenario: See a non regular page (for example, an email)
    Given I am on "/page/1/hello-world"
    Then the response status code should be 404

  Scenario: See a non existing page
    Given I am on "/es/page/99/hello-world"
    Then the response status code should be 404
