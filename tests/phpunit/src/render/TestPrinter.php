<?php

namespace Tozart\Test\render;

use Tozart\os\File;
use Tozart\render\Printer;

/**
 * Printer for testing purposes.
 *
 * @package Tozart\Test\render
 */
class TestPrinter extends Printer {

  /**
   * {@inheritDoc}
   */
  public function templateFileExtension() {
    // TODO: Implement templateFileExtension() method.
  }

  /**
   * {@inheritDoc}
   */
  public function render(File $template, array $context) {
    return '';
  }

}
