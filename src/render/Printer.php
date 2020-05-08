<?php

namespace Tozart\render;

use Tozart\os\File;

abstract class Printer {

  /**
   * Render the given template with the given context.
   *
   * @param File $template
   *   The template file.
   * @param array $context
   *   Array of variables that shape the render context.
   *
   * @return string
   *   The rendered content.
   */
  abstract public function render(File $template, array $context);

}