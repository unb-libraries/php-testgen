<?php

namespace TestGen\generate;

use TestGen\model\TestModel;
use TestGen\os\Directory;
use TestGen\render\TestCaseRenderer;

/**
 * Controller type class for generating test cases.
 *
 * @package TestGen\generate
 */
class TestGenerator {

  // TODO: Make this configurable
  const OUTPUT_ROOT = __DIR__ . '/../../tests/features/';

  /**
   * Directory instance under which to store created test cases.
   *
   * @var Directory
   *   A Directory instance.
   */
  protected $outputRoot;

  /**
   * Create a new TestGenerator instance.
   *
   * @param string $output_root
   *   Path to the output root
   */
  public function __construct($output_root = self::OUTPUT_ROOT) {
    $this->outputRoot = new Directory($output_root);
  }

  /**
   * Generate test cases.
   *
   * @return bool
   *   True if test cases were successfully generated. False otherwise.
   */
  public function generate() {
    $model = new TestModel('route', 'behat');
    $renderer = new TestCaseRenderer();
    $template = $renderer->render($model);

    $feature_filename = $model->getId() . '.feature';
    if ($file = fopen($this->outputRoot->join($feature_filename), 'w')) {
      fwrite($file, $template);
      fclose($file);
      return TRUE;
    }

    return FALSE;
  }

}
