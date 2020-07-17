<?php

namespace Tozart\render;

/**
 * Interface for renderer implementations.
 *
 * @package Tozart\render
 */
interface RendererInterface {

  /**
   * Render the given subject.
   *
   * @param \Tozart\Subject\SubjectInterface $subject
   *   The subject to render.
   *
   * @return string
   *   The generated content.
   */
  public function render($subject);

}
