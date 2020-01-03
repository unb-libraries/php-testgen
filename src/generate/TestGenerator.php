<?php

namespace TestGen\generate;

use TestGen\os\Directory;

/**
 * Controller type class for generating test cases.
 *
 * @package TestGen\generate
 */
class TestGenerator {

  // TODO: Make this configurable
  const OUTPUT_ROOT = __DIR__ . '/../../tests/features/';
  const TEMPLATE_ROOT = __DIR__ . '/../../templates/';

  /**
   * Directory instance under which to store created test cases.
   *
   * @var Directory
   *   A Directory instance.
   */
  protected $outputRoot;

  /**
   * Directory instance under which templates are stored.
   *
   * @var Directory
   *   A Directory instance.
   */
  protected $templateRoot;

  /**
   * Getter for outputRoot.
   *
   * @return Directory
   *   A Directory instance.
   */
  protected function outPutRoot() {
    return $this->outputRoot;
  }

  /**
   * Getter for templateRoot.
   *
   * @return Directory
   *   A Directory instance.
   */
  protected function templateRoot() {
    return $this->templateRoot;
  }

  /**
   * Create a new TestGenerator instance.
   *
   * @param string $output_root
   *   Path to the output root
   * @param string $template_root
   *   Path to the template root
   */
  public function __construct($output_root = self::OUTPUT_ROOT, $template_root = self::TEMPLATE_ROOT) {
    $this->outputRoot = new Directory($output_root);
    $this->templateRoot = new Directory($template_root);
  }

  /**
   * Generate test cases.
   */
  public function generate() {
    foreach ($this->templateRoot()->files() as $template) {
      $template->copy($this->outPutRoot());
    }
  }

}
