<?php

namespace Tozart\Subject;

use Tozart\Model\ModelInterface;

/**
 * Interface for subject factory implementations.
 *
 * @package Tozart\Subject
 */
interface SubjectFactoryInterface {

  /**
   * Create a subject based on the given specification.
   *
   * @param array $specification
   *   The subject specification.
   *
   * @return \Tozart\Subject\SubjectInterface
   *   A subject instance.
   */
  public function create(array $specification);

}
