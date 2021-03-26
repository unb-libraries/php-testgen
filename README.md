# Trupal
A PHP framework to auto-generate common test cases independent of the test framework used to execute those tests. 

# Installation
`composer require --dev unb-libraries/trupal`

## Trupal CLI

### Bash

Copy the following into your ```.bash_profile```

```shell
# Trupal alias
alias trupal='./vendor/unb-libraries/trupal/Console/trupal'
```

### Fish

Create a function in ```~/.config/fish/functions/trupal.fish``` with the following content:

```shell
function trupal -d "Execute Trupal commands"
  ./vendor/unb-libraries/trupal/Console/trupal $argv[1..-1];
end
```

# Usage

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

## Generate test cases:
The easiest way to generate test cases is via the Trupal CLI:

```shell
trupal generate <SUBJECT_DIR> <OUTPUT_DIR>
```


