<?php

namespace Tozart\render;

use Tozart\Subject\SubjectInterface;

/**
 * Interface for render context factories.
 *
 * @package Tozart\render
 */
interface RenderContextFactoryInterface {

  /**
   * Create a context to render the given subject.
   *
   * @param \Tozart\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return \Tozart\render\RenderContextInterface
   *   A render context instance.
   */
  public function create(SubjectInterface $subject);

}
