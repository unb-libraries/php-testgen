<?php

namespace Trupal\Test\Model;

use Trupal\Model\ModelInterface;
use Trupal\Test\TrupalTestCase;
use Trupal\Trupal;

/**
 * Test class for testing model creation.
 *
 * @package Trupal\Test\Model
 */
class ModelFactoryTest extends TrupalTestCase {

  /**
   * A model factory instance.
   *
   * @var \Trupal\Model\ModelFactory
   */
  protected static $_modelFactory;

  /**
   * Retrieve a model factory instance.
   *
   * @return \Trupal\Model\ModelFactory
   *   A model factory object.
   */
  protected static function modelFactory() {
    if (!isset(static::$_modelFactory)) {
      static::$_modelFactory = Trupal::modelFactory();
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
        $types[] = $model_specification['type'];
        yield [
          $model_specification['type'],
          ModelInterface::class
        ];
      }
    }
    yield [
      implode('', array_keys($types)),
    ];
  }

}
