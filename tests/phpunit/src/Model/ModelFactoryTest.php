<?php

namespace Tozart\Test\Model;

use Tozart\Test\TozartTestCase;
use Tozart\Tozart;

/**
 * Test class for testing model creation.
 *
 * @package Tozart\Test\Model
 */
class ModelFactoryTest extends TozartTestCase {

  /**
   * A model factory instance.
   *
   * @var \Tozart\Model\ModelFactory
   */
  protected static $_modelFactory;

  /**
   * Retrieve a model factory instance.
   *
   * @return \Tozart\Model\ModelFactory
   *   A model factory object.
   */
  protected static function modelFactory() {
    if (!isset(static::$_modelFactory)) {
      static::$_modelFactory = Tozart::modelFactory();
    }
    return static::$_modelFactory;
  }

  /**
   * Test that a given type creates a model of the expected class.
   *
   * @param string $type
   *   The model type.
   * @param string|null $expected_class
   *   A fully namespaced class identifier. NULL indicates
   *   the expectation that no model can be created for
   *   the given type.
   *
   * @dataProvider typeProvider
   */
  public function testCreateModel($type, $expected_class = NULL) {
    $model = $this->modelFactory()->create($type);
    if ($expected_class) {
      $this->assertInstanceOf($expected_class, $model);
    }
    else {
      $this->assertFalse($model);
    }
  }

  /**
   * Data provider for testCreateModel().
   *
   * @return \Generator
   *   A generator which on each iteration will
   *   produce an array containing
   *   - a model type
   *   and optionally
   *   - a classname, of which the produced model
   *   is expected to be an instance.
   */
  public function typeProvider() {
    $types = [];
    $discoveries = $this->modelFactory()->discovery()->discover();
    foreach ($discoveries as $dir => $files) {
      foreach ($files as $file_path => $file) {
        $model_specification = $file->parse();
        if (!array_key_exists($model_specification['type'], $types)) {
          $types[$model_specification['type']] = $model_specification['class'];
          yield [
            $model_specification['type'],
            $model_specification['class'],
          ];

        }
        else {
          yield [
            $model_specification['type'],
            $types[$model_specification['type']],
          ];
        }
      }
    }
    yield [
      implode('', array_keys($types)),
    ];
  }

}
