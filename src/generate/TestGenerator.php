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
   * Generate test cases.
   *
   * @param Directory|string $output_root
   *   Directory or path to directory into which to put generated files.
   * @param Directory|string $template_root
   *   Directory or path to directory which contains template files.
   */
  public function generate($output_root = self::OUTPUT_ROOT, $template_root = self::TEMPLATE_ROOT) {
    if (\is_string($output_root)) {
      $output_root= new Directory($output_root);
    }
    if (\is_string($template_root)) {
      $template_root = new Directory($template_root);
    }

    foreach ($template_root->files() as $template) {
      $template->copy($output_root);
    }
  }

}
