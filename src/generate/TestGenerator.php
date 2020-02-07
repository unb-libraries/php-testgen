<?php

namespace TestGen\generate;

use TestGen\model\Model;
use TestGen\os\Directory;
use TestGen\os\File;

/**
 * Controller type class for generating test cases.
 *
 * @package TestGen\generate
 */
class TestGenerator {

  // TODO: Make this configurable
  const OUTPUT_ROOT = __DIR__ . '/../../tests/features/';
  const TEMPLATE_ROOT = __DIR__ . '/../../templates/';
  const MODEL_ROOT =__DIR__ . '/../../models/';

  /**
   * Root folder for models.
   *
   * @var Directory
   */
  protected $modelRoot;

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
   * Create a new TestGenerator instance.
   *
   * @param string|Directory $output_root
   *   Directory instance or path to a directory.
   * @param string|Directory $model_root
   *   Directory instance or path to a directory.
   * @param string|Directory $template_root
   *   Directory instance or path to a directory.
   */
  public function __construct($output_root = self::OUTPUT_ROOT, $model_root = self::MODEL_ROOT, $template_root = self::TEMPLATE_ROOT) {
    $this->setModelRoot($model_root);
    $this->setTemplateRoot($template_root);
    $this->setOutputRoot($output_root);
  }

  /**
   * Generate test cases.
   */
  public function generate() {
    foreach ($this->discoverModels() as $model) {
      if ($template = $this->findTemplate($model)) {
        $this->render($template);
      }
    }
  }

  /**
   * Discover and load models.
   *
   * @return Model[]
   *   An array of model instances.
   */
  protected function discoverModels() {
    $models = [];
    foreach ($this->getModelRoot()->files() as $model_definition) {
      if ($model = Model::createFromFile($model_definition)) {
        $models[$model->getId()] = $model;
      }
    }
    return $models;
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
   * @param File $template
   *   The template file to render.
   */
  protected function render(File $template) {
    $template->copy($this->getOutputRoot());
  }

}
