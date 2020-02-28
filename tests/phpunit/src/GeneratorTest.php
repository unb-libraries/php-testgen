<?php

namespace TestGen\Test;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use TestGen\generate\TestGenerator;
use TestGen\model\ModelDefinition;
use TestGen\model\ModelFactory;
use TestGen\os\Directory;
use TestGen\os\File;
use TestGen\Test\model\ExampleModel;
use TestGen\Test\render\TestEngine;

/**
 * Test the TestGenerator class.
 *
 * @package TestGen\Test
 */
class GeneratorTest extends FileSystemTestCase {

  use PrivateAccessTrait;

  /**
   * A test generator instance.
   *
   * @var TestGenerator
   */
  protected $generator;

  /**
   * Retrieve a TestGenerator instance.
   *
   * @return TestGenerator
   *   A test generator instance.
   */
  protected function getGenerator() {
    return $this->generator;
  }

  /**
   * Retrieve the directory containing the test templates.
   *
   * @return Directory
   *   A directory.
   */
  protected function templateRoot() {
    return new Directory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'templates');
  }

  /**
   * Retrieve the directory containing the test models.
   *
   * @return Directory
   *   A directory.
   */
  protected function modelRoot() {
    return new Directory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models');
  }

  /**
   * Retrieve the directory containing the test model definitions.
   *
   * @return Directory
   *   A directory.
   */
  protected function modelDefinitionRoot() {
    return new Directory(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'model_definitions');
  }

  /**
   * Retrieve the output directory.
   *
   * @return Directory
   *   A directory.
   */
  protected function outputRoot() {
    return new Directory($this->root() . DIRECTORY_SEPARATOR . 'output');
  }

  /**
   * {@inheritDoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $generator = new TestGenerator(
      new ModelFactory(),
      new TestEngine(),
      $this->modelDefinitionRoot(),
      $this->templateRoot());
    $generator->setModelRoot($this->modelRoot());
    $generator->setOutputRoot($this->outputRoot());
    $this->generator = $generator;
  }

  /**
   * Test that all valid YAML files inside the configured model root can be turned into model instances.
   */
  public function testDiscoverModelDescriptions() {
    $expected_number_of_models = 0;
    foreach ($this->modelRoot()->files() as $model_file) {
      if ($this->isValidYml($model_file->path())) {
        $expected_number_of_models++;
      }
    }
    $models = $this->getPrivateMethodResult($this->getGenerator(), 'discoverModelDescriptions');
    $this->assertEquals($expected_number_of_models, count($models));
  }

  /**
   * Whether the file with the given name contains valid YAML.
   *
   * @param $filename
   *   The filename.
   *
   * @return bool
   *   TRUE if the given filename is a YAML file and contains valid YAML.
   *   FALSE otherwise.
   */
  protected function isValidYml($filename) {
    try {
      if (pathinfo($filename)['extension'] === 'yml') {
        Yaml::parse(file_get_contents($filename));
        return TRUE;
      }
      else {
        return FALSE;
      }
    }
    catch (ParseException $e) {
      return FALSE;
    }
  }

  /**
   * Test that a template for a model can be found.
   */
  public function testFindTemplate() {
    $model_definition = new ModelDefinition('example', ExampleModel::class);
    $model = new ExampleModel('test_model', $model_definition, [
      'property1' => 'foo',
      'property2'=> 'bar',
    ]);

    $template = $this->getPrivateMethodResult($this->getGenerator(), 'findTemplate', $model);
    if ($this->templateRoot()->containsFile('test_model.example.feature') || $this->templateRoot()->containsFile('example.feature')) {
      $this->assertInstanceOf(File::class, $template);
    }
    else {
      $this->assertFalse($template);
    }
  }

}