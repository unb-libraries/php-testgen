<?php

namespace Tozart\render;

/**
 * Interface for RenderContext implementations.
 *
 * A render context tells a renderer how to render a subject.
 *
 * @package Tozart\render
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
   * @return \Tozart\os\FileInterface
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
