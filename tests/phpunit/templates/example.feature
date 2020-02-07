# Sample Behat Feature
# Ref : phase2/behat-suite

@api
Feature: Test Use Case
  As a Developer
  In order to test a feature
  I need to be able to generate a test

  Scenario: Create new feature
    Given I am logged in.
    When I go to {{model.id}}
    Then I should receive a HTTP 200 response.




