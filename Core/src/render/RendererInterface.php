<?php

namespace Trupal\Core\render;

/**
 * Interface for renderer implementations.
 *
 * @package Trupal\Core\render
 */
interface RendererInterface {

  /**
   * Render the given context.
   *
   * @param \Trupal\Core\render\RenderContextInterface $context
   *   The render context.
   *
   * @return string
   *   The generated content.
   */
  public function render(RenderContextInterface $context);

}
