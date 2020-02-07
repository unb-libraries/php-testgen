# Sample Behat Feature
# Ref : phase2/behat-suite

@api
Feature: Test Use Case
  As a Developer
  In order to test a feature
  I need to be able to generate a test

  Scenario: Create new feature
    Given I am a developer
    When I develop a feature
    And I generate a test case
    Then this file should be placed inside my test directory

