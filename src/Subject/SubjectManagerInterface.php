<?php

namespace Tozart\Subject;

/**
 * Interface for subject manager implementations.
 *
 * @package Tozart\Subject
 */
interface SubjectManagerInterface {

  /**
   * Retrieve all subjects.
   *
   * @return \Tozart\Subject\SubjectInterface[]
   *   An array of subject instances, keyed
   *   by their IDs.
   */
  public function subjects();

  /**
   * Whether a model of the given type is known to the manager.
   *
   * @param string $type
   *   The type.
   *
   * @return bool
   *   TRUE if the manager is aware of a model with
   *   the given type. FALSE otherwise.
   */
  public function has($type);

  /**
   * Retrieve the subject with the given ID.
   *
   * @param string $id
   *   A string.
   *
   * @return \Tozart\Subject\SubjectInterface
   *   A subject instance.
   */
  public function get($id);

}
