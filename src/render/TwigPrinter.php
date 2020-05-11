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
   * Create a new RenderEngine based on Twig.
   *
   * @param string $path_to_template_dir
   *   The path to the template directory.
   */
  public function __construct($path_to_template_dir) {
    $loader = new FilesystemLoader($path_to_template_dir);
    $this->environment = new Environment($loader);
  }

  /**
   * {@inheritDoc}
   */
  public function templateFileExtension() {
    return 'twig';
  }

  /**
   * {@inheritDoc}
   */
  public function render(File $template, array $context) {
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
