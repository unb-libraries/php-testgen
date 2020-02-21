<?php

namespace TestGen\generate;

use TestGen\model\Model;
use TestGen\model\ModelDefinition;
use TestGen\model\ModelFactory;
use TestGen\os\Directory;
use TestGen\os\File;
use TestGen\os\ParsableFile;
use TestGen\render\RenderEngine;

/**
 * Controller type class for generating test cases.
 *
 * @package TestGen\generate
 */
class TestGenerator {

  // TODO: Make this configurable
  const OUTPUT_ROOT = __DIR__ . '/../../tests/features/';
  const TEMPLATE_ROOT = __DIR__ . '/../../templates/';
  const MODEL_ROOT = __DIR__ . '/../../models/';
  const MODEL_DEFINITION_ROOT = __DIR__ . '/../../model_definitions/';

  /**
   * Root folder for models.
   *
   * @var Directory
   */
  protected $modelRoot;

  /**
   * Root folder for model definitions.
   *
   * @var Directory
   */
  protected $modelDefinitionRoot;

  /**
   * Root folder for templates.
   *
   * @var Directory
   */
  protected $templateRoot;

  /**
   * @var Directory
   */
  protected $outputRoot;

  /**
   * @var RenderEngine
   */
  protected $renderer;

  /**
   * The model factory.
   *
   * @var ModelFactory
   */
  protected $modelFactory;

  /**
   * Retrieve the model root.
   *
   * @return Directory
   *   A directory instance.
   */
  public function getModelRoot() {
    return $this->modelRoot;
  }

  /**
   * Assign a model root.
   *
   * @param string|Directory $model_root
   *   A directory instance or the path to a directory.
   */
  public function setModelRoot($model_root) {
    if (is_string($model_root)) {
      $model_root = new Directory($model_root);
    }
    $this->modelRoot = $model_root;
  }

  /**
   * Retrieve the model definition root.
   *
   * @return Directory
   *   A directory instance.
   */
  public function getModelDefinitionRoot() {
    return $this->modelDefinitionRoot;
  }

  /**
   * Assign a model definition root.
   *
   * @param string|Directory $model_definition_root
   *   A directory instance or the path to a directory.
   */
  public function setModelDefinitionRoot($model_definition_root) {
    if (is_string($model_definition_root)) {
      $model_definition_root = new Directory($model_definition_root);
    }
    $this->modelDefinitionRoot = $model_definition_root;
  }

  /**
   * Retrieve the template root.
   *
   * @return Directory
   *   A directory instance.
   */
  public function getTemplateRoot() {
    return $this->templateRoot;
  }

  /**
   * Assign a template root.
   *
   * @param string|Directory $template_root
   *   A directory instance or the path to a directory.
   */
  public function setTemplateRoot($template_root) {
    if (is_string($template_root)) {
      $template_root = new Directory($template_root);
    }
    $this->templateRoot = $template_root;
  }

  /**
   * Retrieve the output root.
   *
   * @return Directory
   *   A directory instance.
   */
  public function getOutputRoot() {
    return $this->outputRoot;
  }

  /**
   * Retrieve the currently used render engine.
   *
   * @return RenderEngine
   *   The render engine.
   */
  public function getRenderer() {
    return $this->renderer;
  }

  /**
   * Assign the given render to the generator.
   *
   * @param RenderEngine $engine
   *   The render engine to use.
   */
  public function setRenderer(RenderEngine $engine) {
    $this->renderer = $engine;
  }

  /**
   * Assign a output root.
   *
   * @param string|Directory $output_root
   *   A directory instance or the path to a directory.
   */
  public function setOutputRoot($output_root) {
    if (is_string($output_root)) {
      $output_root = new Directory($output_root);
    }
    $this->outputRoot = $output_root;
  }

  /**
   * Retrieve the model factory instance.
   *
   * @return ModelFactory
   *   A model factory instance.
   */
  public function getModelFactory() {
    return $this->modelFactory;
  }

  /**
   * Set the model factory.
   *
   * @param $model_factory
   *   A model factory instance.
   */
  public function setModelFactory($model_factory) {
    $this->modelFactory = $model_factory;
    foreach ($this->discoverModelDefinitions() as $parsable_file) {
      if ($model_definition = ModelDefinition::createFromFile($parsable_file)) {
        $this->modelFactory->addDefinition($model_definition);
      }
    }
  }

  /**
   * Create a new TestGenerator instance.
   *
   * @param ModelFactory $model_factory
   *   The model factory.
   * @param RenderEngine $engine
   *   The render engine to render templates.
   * @param string|Directory $output_root
   *   Directory instance or path to a directory.
   * @param string|Directory $model_root
   *   Directory instance or path to a directory.
   * @param string|Directory $model_definition_root
   *   Directory instance or path to a directory.
   * @param string|Directory $template_root
   *   Directory instance or path to a directory.
   */
  public function __construct(ModelFactory $model_factory, RenderEngine $engine, $output_root = self::OUTPUT_ROOT, $model_root = self::MODEL_ROOT,
                              $model_definition_root = self::MODEL_DEFINITION_ROOT, $template_root = self::TEMPLATE_ROOT) {
    $this->modelFactory = $model_factory;
    $this->setModelRoot($model_root);
    $this->setModelDefinitionRoot($model_definition_root);
    $this->setTemplateRoot($template_root);
    $this->setOutputRoot($output_root);
    $this->renderer = $engine;
  }

  /**
   * Generate test cases.
   */
  public function generate() {
    foreach ($this->loadModels() as $model) {
      if ($template = $this->findTemplate($model)) {
        $this->render($model, $template);
      }
    }
  }

  /**
   * Load models.
   *
   * @return Model[]
   *   An array of model instances.
   */
  protected function loadModels() {
    $models = [];
    foreach ($this->discoverModelDescriptions() as $model_description) {
      if ($model = $this->getModelFactory()->createFromFile($model_description)) {
        $models[$model->getId()] = $model;
      }
    }
    return $models;
  }

  /**
   * Discover parsable model description files.
   *
   * @return ParsableFile[]
   *   An array of parsable files.
   */
  protected function discoverModelDescriptions() {
    $model_descriptions = [];
    foreach ($this->getModelRoot()->files() as $model_description) {
      // TODO: Remove this unnecessary, hard coded dependency.
      if ($model_description instanceof ParsableFile) {
        $model_descriptions[] = $model_description;
      }
    }
    return $model_descriptions;
  }

  /**
   * Discover parsable model definition files.
   *
   * @return ParsableFile[]
   *   An array of parsable files.
   */
  protected function discoverModelDefinitions() {
    $model_definitions = [];
    foreach ($this->getModelDefinitionRoot()->files() as $model_definition) {
      // TODO: Remove this unnecessary, hard coded dependency.
      if ($model_definition instanceof ParsableFile) {
        $model_definitions[] = $model_definition;
      }
    }
    return $model_definitions;
  }

  /**
   * Find a template for the given model.
   *
   * @param Model $model
   *   The model.
   *
   * @return FALSE|\TestGen\os\File
   *   The template file, if one was found. FALSE otherwise.
   */
  protected function findTemplate(Model $model) {
    $filename_candidates = [
      sprintf('%s.%s.%s', $model->getId(), $model->getType(), 'feature'),
      sprintf('%s.%s', $model->getType(), 'feature'),
    ];

    foreach ($filename_candidates as $filename) {
      if ($template = $this->getTemplateRoot()->find($filename)) {
        return $template;
      }
    }
    return FALSE;
  }

  /**
   * Render the given template file.
   *
   * @param Model $model
   *   The model to render.
   * @param File $template
   *   The template file to render.
   */
  protected function render(Model $model, File $template) {
    $test_case = $this->getOutputRoot()->put($template->name());
    $content = $this->getRenderer()->render($template, $model->getProperties());
    $test_case->setContent($content);
  }

}
