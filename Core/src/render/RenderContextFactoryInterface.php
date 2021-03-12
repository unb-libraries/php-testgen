<?php

namespace Trupal\Core\render;

use Trupal\Core\Subject\SubjectInterface;

/**
 * Interface for render context factories.
 *
 * @package Trupal\Core\render
 */
interface RenderContextFactoryInterface {

  /**
   * Create a context to render the given subject.
   *
   * @param \Trupal\Core\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return \Trupal\Core\render\RenderContextInterface
   *   A render context instance.
   */
  public function create(SubjectInterface $subject);

}
