<?php

namespace TestGen\Test\model;

use PHPUnit\Framework\TestCase;
use TestGen\model\Model;
use TestGen\model\ModelDefinition;
use TestGen\model\ModelFactory;
use TestGen\model\PageModel;
use TestGen\os\Directory;
use TestGen\os\YamlFile;

class ModelFactoryTest extends TestCase {

  const MODEL_TYPE_ID = 'example';
  const MODEL_CLASS = ExampleModel::class;
  const MODEL_DEFINITION_CLASS = ModelDefinition::class;
  const MODEL_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models';

  /**
   * Directory containing models.
   *
   * @var Directory
   */
  protected $modelsDirectory;

  /**
   * The model factory.
   *
   * @var ModelFactory
   */
  protected $factory;

  /**
   * Retrieve the model factory.
   *
   * @return ModelFactory
   *   A model factory instance.
   */
  protected function getModelFactory() {
    return $this->factory;
  }

  /**
   * Retrieve the directory which contains models.
   *
   * @return Directory
   */
  protected function getModelsDirectory() {
    return $this->modelsDirectory;
  }

  /**
   * {@inheritDoc}
   */
  protected function setUp(): void {
    $this->modelsDirectory = new Directory(self::MODEL_DIR);
    $model_definition = new ModelDefinition(self::MODEL_TYPE_ID, self::MODEL_CLASS, [
      'property1',
      'property2',
    ], [
      'option1',
    ]);
    $this->factory = new ModelFactory([$model_definition]);
    parent::setUp();
  }

  /**
   * Test that a valid model description will be mapped to the expected class.
   */
  public function testCreateModel() {
    $model_description = new YamlFile('valid_model.example.yml', $this->getModelsDirectory());
    /** @var ExampleModel $example_model */
    $example_model = $this->getModelFactory()->createFromFile($model_description);
    $this->assertInstanceOf(self::MODEL_CLASS, $example_model);
    $this->assertEquals(self::MODEL_TYPE_ID, $example_model->getType());
  }

  /**
   * Test that an invalid model description will not be mapped to any class.
   */
  public function testCreateModelFails() {
    $model_description = new YamlFile('invalid_model.example.yml', $this->getModelsDirectory());
    /** @var PageModel $example_model */
    $example_model = $this->getModelFactory()->createFromFile($model_description);
    $this->assertFalse($example_model);
  }

  /**
   * Test that a test definition of a given type can be found.
   */
  public function testFindDefinitionForModelType() {
    $this->assertInstanceOf(self::MODEL_DEFINITION_CLASS, $this
        ->getModelFactory()
        ->getDefinition(self::MODEL_TYPE_ID));
  }

}
