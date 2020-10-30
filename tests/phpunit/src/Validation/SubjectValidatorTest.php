<?php

namespace Tozart\Test\Validation;

use Tozart\Discovery\FactoryInterface;
use Tozart\Test\Subject\ExampleSubject;

/**
 * Test the SubjectValidator class.
 *
 * @covers \Tozart\Validation\SubjectValidator
 *
 * @package Tozart\Test\Validation
 */
class SubjectValidatorTest extends SpecificationValidatorTest {

  /**
   * {@inheritDoc}
   */
  protected function createValidator() {
    return new TestableSubjectValidator($this->createParser(), $this->createModelFactory());
  }

  /**
   * Create a model factory test double.
   *
   * @return \Tozart\Discovery\FactoryInterface
   *   An object pretending to be a model factory.
   */
  protected function createModelFactory() {
    $factory = $this->createStub(FactoryInterface::class);
    $factory->method('create')
      ->willReturnMap([
        ['test', $this->createModel()],
      ]);
    return $factory;
  }

  /**
   * Create a model test double.
   *
   * @return \Tozart\Model\ModelInterface
   *   An object pretending to be a model.
   */
  protected function createModel() {
    return new SubjectValidationTestModel([
      'type' => 'test',
      'subject_class' => ExampleSubject::class,
      'requirements' => ['requiredProperty' => ''],
      'options' => ['optionalProperty' => 1],
    ]);
  }

  /**
   * {@inheritDoc}
   */
  public function fileProvider() {
    return [
      // Should fail because type is not given.
      [$this->createFile('subject_0', 'test', "type: ''"), FALSE],
      // Should fail because a model of type "sample" does not exist.
      [$this->createFile('subject_1', 'test', "type: 'sample'"), FALSE],
      // Should fail because the subject does not provide required property definitions.
      [$this->createFile('subject_2', 'test', "type: 'test'"), FALSE],
      // Should pass because optional properties can be omitted.
      [$this->createFile('subject_3', 'test', "type: 'test'\nrequiredProperty: 'someValue'"), TRUE],
      // Should fail because requiredProperty's assigned value is invalid.
      [$this->createFile('subject_4', 'test', "type: 'test'\nrequiredProperty: 'anotherValue'"), FALSE],
      // Should fail because optionalProperty's assigned value is invalid.
      [$this->createFile('subject_5', 'test', "type: 'test'\nrequiredProperty: 'someValue'\noptionalProperty: 0"), FALSE],
      // Should pass.
      [$this->createFile('subject_6', 'test', "type: 'test'\nrequiredProperty: 'someValue'\noptionalProperty: 2"), TRUE],
    ];
  }

}
