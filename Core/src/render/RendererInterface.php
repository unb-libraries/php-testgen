<?php

namespace Trupal\render;

/**
 * Interface for renderer implementations.
 *
 * @package Trupal\render
 */
interface RendererInterface {

  /**
   * Render the given context.
   *
   * @param \Trupal\render\RenderContextInterface $context
   *   The render context.
   *
   * @return string
   *   The generated content.
   */
  public function render(RenderContextInterface $context);

}
