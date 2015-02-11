@store @registration @view
Feature: user registration
  In order to become a customer
  As an anonymous user
  I need to register

  Scenario: Access register
    Given I am on "/register"
    Then I should see "Register"
