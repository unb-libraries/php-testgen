<?php

namespace Tozart\Test\render;

use Tozart\os\File;
use Tozart\render\Printer;

/**
 * Render engine for testing purposes.
 *
 * @package Tozart\Test\render
 */
class TestPrinter extends Printer {

  /**
   * {@inheritDoc}
   */
  public function render(File $template, array $context) {
    return '';
  }

}
