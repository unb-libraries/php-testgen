<?php

namespace Tozart\Test\Subject;

use PHPUnit\Framework\TestCase;
use Tozart\Subject\SubjectModel;
use Tozart\Subject\SubjectFactory;
use Tozart\Subject\Page;
use Tozart\os\Directory;
use Tozart\os\YamlFile;

class SubjectFactoryTest extends TestCase {

  const SUBJECT_TYPE_ID = 'example';
  const SUBJECT_CLASS = ExampleSubject::class;
  const MODEL_CLASS = SubjectModel::class;
  const SUBJECT_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'subjects';

  /**
   * Directory containing models.
   *
   * @var Directory
   */
  protected $modelsDirectory;

  /**
   * The model factory.
   *
   * @var SubjectFactory
   */
  protected $factory;

  /**
   * Retrieve the model factory.
   *
   * @return SubjectFactory
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
    $this->modelsDirectory = new Directory(self::SUBJECT_ROOT);
    $model_definition = new SubjectModel(self::SUBJECT_TYPE_ID, self::SUBJECT_CLASS, [
      'property1',
      'property2',
    ], [
      'option1',
    ]);
    $this->factory = new SubjectFactory([$model_definition]);
    parent::setUp();
  }

  /**
   * Test that a valid model description will be mapped to the expected class.
   */
  public function testCreateModel() {
    $model_description = new YamlFile('valid_subject.example.yml', $this->getModelsDirectory());
    /** @var ExampleSubject $example_model */
    $example_model = $this->getModelFactory()->createFromFile($model_description);
    $this->assertInstanceOf(self::SUBJECT_CLASS, $example_model);
    $this->assertEquals(self::SUBJECT_TYPE_ID, $example_model->getType());
  }

  /**
   * Test that an invalid model description will not be mapped to any class.
   */
  public function testCreateModelFails() {
    $model_description = new YamlFile('invalid_subject.example.yml', $this->getModelsDirectory());
    /** @var Page $example_model */
    $example_model = $this->getModelFactory()->createFromFile($model_description);
    $this->assertFalse($example_model);
  }

  /**
   * Test that a test definition of a given type can be found.
   */
  public function testFindDefinitionForModelType() {
    $this->assertInstanceOf(self::MODEL_CLASS, $this
        ->getModelFactory()
        ->getModel(self::SUBJECT_TYPE_ID));
  }

}
