# Trupal
A PHP framework to auto-generate common test cases independent of the test framework used to execute those tests. 

# Installation
`composer require --dev unb-libraries/trupal`

# Usage

## Create a new Trupal instance:
```php
$trupal = \Trupal\Trupal::instance();
```

## Define a subject
A subject is a definition of a unit to be tested. Define one as follows:
```yaml
id: 'test_page'
type: 'page'
url: '/test/page/1'
public: FALSE
grant_access:
  - member
```

This defines that there should be a non-public page under https://your.site.domain/test/page/1 which is expected to be accessible to any user with the user role `member` and inaccessible to anyone else.

## Generate the test case:
To render the subject definition into an executable test case, run

```php
$trupal->generate('/path/to/subject/folder', '/path/to/another/folder');
```

This will look for subject definitions under `/path/to/subject/folder` and, assuming that's where you store your subject, place the generated test case under `/path/to/another/folder`:

```behat
# Behat Page Access Test
# Ref : phase2/behat-suite

Feature: Visit a page
  As an internet user
  In order to use a website
  I need to be able to access a page.


    Background:
    Given users:
| name | mail | roles |
| user_1 | user_1@example.com | member |
            Scenario: Grant acccess to user_1
        Given I am logged in as user_1
        When I go to /test/page/1
        Then I should get an HTTP 200 response
      
  Scenario: Deny acccess to unauthenticated users
    Given I am not logged in
    When I go to /test/page/1
    Then I should get an HTTP 403 response
```


