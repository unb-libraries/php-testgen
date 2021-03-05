<?php

namespace Trupal\Core\render;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Twig based renderer implementation.
 *
 * @package Trupal\Core\render
 */
class TwigRenderer implements RendererInterface {

  /**
   * The Twig environment.
   *
   * @var Environment
   */
  protected $_environment;

  /**
   * The Twig file system loader.
   *
   * @var FilesystemLoader
   */
  protected $_loader;

  /**
   * Retrieve the Twig environment.
   *
   * @return Environment
   *   An environment instance.
   */
  protected function getEnvironment() {
    return $this->_environment;
  }

  /**
   * Retrieve the Twig file system loader.
   *
   * @return \Twig\Loader\FilesystemLoader
   *   A file system loader instance.
   */
  protected function getLoader() {
    return $this->_loader;
  }

  /**
   * Create a new TwigRenderer instance.
   */
  public function __construct() {
    $this->_loader = new FilesystemLoader();
    $this->_environment = new Environment($this->_loader);
  }

  /**
   * {@inheritDoc}
   */
  public function render(RenderContextInterface $context) {
    try {
      $template = $context->getTemplate();
      if (!in_array($path = $template->directory()->systemPath(), $this->getLoader()->getPaths())) {
        $this->getLoader()->addPath($path);
      }
      $content = $this->getEnvironment()
        ->render($context->getTemplate()->name(), $context->getBindings());
    }
    catch (\Exception $e) {
      $content = '';
    }
    return $content;
  }

}
