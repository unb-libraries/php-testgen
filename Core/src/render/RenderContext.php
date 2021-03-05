<?php

namespace Trupal\render;

use Trupal\os\FileInterface;

/**
 * Data structure class containing render information.
 *
 * @package Trupal\render
 */
class RenderContext implements RenderContextInterface {

  /**
   * The array which binds variable names to values.
   *
   * @var array
   */
  protected $_bindings;

  /**
   * The template file.
   *
   * @var \Trupal\os\FileInterface
   */
  protected $_template;

  /**
   * {@inheritDoc}
   */
  public function getBindings() {
    return $this->_bindings;
  }

  /**
   * {@inheritDoc}
   */
  public function getTemplate() {
    return $this->_template;
  }

  /**
   * {@inheritDoc}
   */
  public function getOutputExtension() {
    if (preg_match('/.*\.feature\.\w/', $this->getTemplate()->name())) {
      return 'feature';
    }
    return '';
  }

  /**
   * Create a new RenderContext instance.
   *
   * @param array $bindings
   *   An array of variable names and values.
   * @param \Trupal\os\FileInterface $template
   *   A template file.
   */
  public function __construct(array $bindings, FileInterface $template) {
    $this->_bindings = $bindings;
    $this->_template = $template;
  }

}
