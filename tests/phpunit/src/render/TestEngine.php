<?php

namespace TestGen\Test\render;

use TestGen\os\File;
use TestGen\render\RenderEngine;

/**
 * Render engine for testing purposes.
 *
 * @package TestGen\Test\render
 */
class TestEngine extends RenderEngine {

  /**
   * {@inheritDoc}
   */
  public function render(File $template, array $context) {
    return '';
  }

}
