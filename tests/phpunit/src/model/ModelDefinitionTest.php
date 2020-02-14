<?php

namespace TestGen\Test\model;

use PHPUnit\Framework\TestCase;
use TestGen\model\ModelDefinition;

class ModelDefinitionTest extends TestCase {

  public function testModelClass() {
    $model_definition = new ModelDefinition('example', ExampleModel::class);
    $this->assertEquals(ExampleModel::class, $model_definition->getModelClass());
  }

}