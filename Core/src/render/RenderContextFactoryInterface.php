<?php

namespace Trupal\render;

use Trupal\Subject\SubjectInterface;

/**
 * Interface for render context factories.
 *
 * @package Trupal\render
 */
interface RenderContextFactoryInterface {

  /**
   * Create a context to render the given subject.
   *
   * @param \Trupal\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return \Trupal\render\RenderContextInterface
   *   A render context instance.
   */
  public function create(SubjectInterface $subject);

}
