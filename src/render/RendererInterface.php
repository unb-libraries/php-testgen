<?php

namespace Tozart\render;

/**
 * Interface for renderer implementations.
 *
 * @package Tozart\render
 */
interface RendererInterface {

  /**
   * Render the given context.
   *
   * @param \Tozart\render\RenderContextInterface $context
   *   The render context.
   *
   * @return string
   *   The generated content.
   */
  public function render(RenderContextInterface $context);

}
