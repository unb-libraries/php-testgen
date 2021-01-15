<?php

namespace Trupal\Test\Validation;

use PHPUnit\Framework\TestCase;
use Trupal\Validation\ValidatorFactory;

/**
 * Test the ValidatorFactoryTest class.
 *
 * @package Trupal\Test\Validation
 */
class ValidatorFactoryTest extends TestCase {

  /**
   * The validator factory to test.
   *
   * @var \Trupal\Validation\ValidatorFactoryInterface
   */
  protected $_factory;

  /**
   * Retrieve the validator factory to test.
   *
   * @return \Trupal\Validation\ValidatorFactoryInterface
   *   A validator factory object.
   */
  protected function factory() {
    return $this->_factory;
  }

  /**
   * Set up a factory with validators to test.
   */
  protected function setUp(): void {
    $this->_factory = new ValidatorFactory([
      TestValidator::class,
      FakeValidator::class,
    ]);
    parent::setUp();
  }

  /**
   * Test the "create" method.
   *
   * @param string $id
   *   The ID of validator.
   *
   * @dataProvider validatorIdProvider
   */
  public function testCreate(string $id) {
    $validator = $this->factory()->create($id, []);
    if ($id !== $this->getInvalidId()) {
      $this->assertEquals($validator->getId(), $id);
    }
    else {
      // TODO: Test that failed attempt to create validator will be logged.
      $this->assertNull($validator);
    }
  }

  /**
   * Provide validator IDs.
   *
   * @return array
   *   An array of scenarios.
   */
  public function validatorIdProvider() {
    return array_map(function ($validator_id) {
      return [$validator_id];
    }, array_merge($this->validatorIds(), [$this->getInvalidId()]));
  }

  /**
   * Retrieve valid validator IDs.
   *
   * @return array
   *   An array of strings.
   */
  protected function validatorIds() {
    return [
      TestValidator::getId(),
      FakeValidator::getId(),
    ];
  }

  /**
   * Fabricate an invalid validator ID.
   *
   * @return string
   *   A string.
   */
  protected function getInvalidId() {
    return implode('_', $this->validatorIds());
  }

  /**
   * Test the "getSpecifications" method.
   */
  public function testGetSpecifications() {
    $specifications = $this->factory()->getSpecifications();
    $validator_ids = array_map(function ($specification) {
      if (array_key_exists('id', $specification)) {
        return $specification['id'];
      }
      return 'Undefined';
    }, $specifications);
    $this->assertEquals($this->validatorIds(), array_values($validator_ids));
  }

}
