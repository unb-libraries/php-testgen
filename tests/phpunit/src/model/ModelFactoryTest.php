<?php

namespace TestGen\Test\model;

use PHPUnit\Framework\TestCase;
use TestGen\model\ModelDefinition;
use TestGen\model\ModelFactory;

class ModelFactoryTest extends TestCase {

  const MODEL_TYPE_ID = 'example';
  const MODEL_CLASS = ExampleModel::class;
  const MODEL_DEFINITION_CLASS = ModelDefinition::class;

  /**
   * Test that a model can be manufactured from a given model definition.
   */
  public function testCreateModel() {
    $model_definition = new ModelDefinition(self::MODEL_TYPE_ID, self::MODEL_CLASS);
    $model_factory = new ModelFactory([$model_definition]);
    $example_model = $model_factory->create(self::MODEL_TYPE_ID);
    $this->assertInstanceOf(self::MODEL_CLASS, $example_model);
  }

  /**
   * Test that a test definition of a given type can be found.
   */
  public function testFindDefinitionForModelType() {
    $model_definition = new ModelDefinition(self::MODEL_TYPE_ID, self::MODEL_CLASS);
    $model_factory = new ModelFactory([$model_definition]);
    $this->assertInstanceOf(self::MODEL_DEFINITION_CLASS, $model_factory->getDefinition(self::MODEL_TYPE_ID));
  }

}
