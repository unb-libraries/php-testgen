<?php

namespace Trupal\render;

/**
 * Interface for RenderContext implementations.
 *
 * A render context tells a renderer how to render a subject.
 *
 * @package Trupal\render
 */
interface RenderContextInterface {

  /**
   * Retrieve the array which binds variable names to values.
   *
   * @return array
   *   An array of the form NAME => VALUE.
   */
  public function getBindings();

  /**
   * Retrieve the template file.
   *
   * @return \Trupal\os\FileInterface
   */
  public function getTemplate();

  /**
   * Retrieve the output file extension.
   *
   * @return string
   *   A string.
   */
  public function getOutputExtension();



}
