<?php

namespace Tozart\render;

use Tozart\os\File;

/**
 * Data structure class containing render information.
 *
 * @package Tozart\render
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
   * @var \Tozart\os\File
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
   * Create a new RenderContext instance.
   *
   * @param array $bindings
   *   An array of variable names and values.
   * @param \Tozart\os\File $template
   *   A template file.
   */
  public function __construct(array $bindings, File $template) {
    $this->_bindings = $bindings;
    $this->_template = $template;
  }

}
