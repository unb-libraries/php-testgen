<?php

namespace Trupal\Test\Validation;

use Trupal\Test\Subject\ExampleSubject;
use Trupal\Validation\ModelValidator;

/**
 * Test the ModelValidator class.
 *
 * @package Trupal\Test\Validation
 */
class ModelValidatorTest extends SpecificationValidatorTest {

  /**
   * {@inheritDoc}
   */
  protected function createValidator() {
    return new ModelValidator($this->createParser());
  }

  /**
   * {@inheritDoc}
   */
  public function fileProvider() {
    $subject_class = ExampleSubject::class;

    return [
      // Should fail because type is not given.
      [$this->createFile('model_0', 'test', "type: ''"), FALSE],
      // Should fail because type is not a string.
      [$this->createFile('model_1', 'test', "type: 123"), FALSE],
      // Should fail because class does not implement SubjectInterface.
      [$this->createFile('model_2', 'test', "type: 'test'\nsubject_class: '\Trupal\Test\ValidationModelValidatorTest'"), FALSE],
      // Should pass because requirements and options are optional.
      [$this->createFile('model_3', 'test', "type: 'test'\nsubject_class: '{$subject_class}'"), TRUE],
      // Should fail because requirements must be an array.
      [$this->createFile('model_4', 'test', "type: 'test'\nsubject_class: '{$subject_class}'\nrequirements: ''"), FALSE],
      // Should pass because options are optional.
      [$this->createFile('model_5', 'test', "type: 'test'\nsubject_class: '{$subject_class}'\nrequirements: [requiredProperty]"), TRUE],
      // Should fail because options is not an array.
      [$this->createFile('model_6', 'test', "type: 'test'\nsubject_class: '{$subject_class}'\nrequirements: [requiredProperty]\noptions: ''"), FALSE],
      // Should fail because each option must provide a default value.
      [$this->createFile('model_7', 'test', "type: 'test'\nsubject_class: '{$subject_class}'\nrequirements: [requiredProperty]\noptions: [optionalProperty]"), FALSE],
      // Should pass.
      [$this->createFile('model_8', 'test', "type: 'test'\nsubject_class: '{$subject_class}'\nrequirements: [requiredProperty]\noptions: {optionalProperty:2}"), TRUE],
      // Should fail because class does not implement the ModelInterface.
      [$this->createFile('model_9', 'test', "type: 'test'\nclass: '\Trupal\Test\ValidationModelValidatorTest'\nsubject_class: '{$subject_class}'\nrequirements: [requiredProperty]\noptions: {optionalProperty:2}"), FALSE],
    ];
  }

}
