<?php

namespace TestGen\Test\model;

use PHPUnit\Framework\TestCase;
use TestGen\model\ModelDefinition;
use TestGen\os\Directory;
use TestGen\os\YamlFile;

class ModelDefinitionTest extends TestCase {

  const MODEL_DEFINITION_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'model_definitions';

  public function testModelClass() {
    $model_definition = new ModelDefinition('example', ExampleModel::class);
    $this->assertEquals(ExampleModel::class, $model_definition->getModelClass());
  }

  public function testCreateFromFile() {
    $yaml = new YamlFile('example.yml', new Directory(self::MODEL_DEFINITION_DIR));
    $model_definition = ModelDefinition::createFromFile($yaml);
    $this->assertInstanceOf(ModelDefinition::class, $model_definition);
  }

}