<?php

namespace Tozart\render;

use Tozart\os\File;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Template render engine based on Twig.
 *
 * @package Tozart\render
 */
class TwigPrinter extends Printer {

  /**
   * The Twig environment.
   *
   * @var Environment
   */
  protected $environment;

  /**
   * @return Environment
   *   The Twig environment;
   */
  protected function getEnvironment() {
    return $this->environment;
  }

  /**
   * {@inheritDoc}
   */
  protected function init() {
    $paths = [];
    foreach ($this->templateDiscovery()->directoryStack() as $directory) {
      $paths[] = $directory->systemPath();
    }

    $loader = new FilesystemLoader($paths);
    $this->environment = new Environment($loader);
  }

  /**
   * {@inheritDoc}
   */
  protected function doRender(File $template, array $context) {
    try {
      $content = $this->getEnvironment()
        ->render($template->name(), $context);
    }
    catch (\Exception $e) {
      $content = '';
    }
    return $content;
  }

}
