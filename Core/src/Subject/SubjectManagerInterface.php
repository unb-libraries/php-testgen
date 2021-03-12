<?php

namespace Trupal\Core\Subject;

/**
 * Interface for subject manager implementations.
 *
 * @package Trupal\Core\Subject
 */
interface SubjectManagerInterface {

  /**
   * Retrieve all subjects.
   *
   * @return \Trupal\Core\Subject\SubjectInterface[]
   *   An array of subject instances, keyed
   *   by their IDs.
   */
  public function subjects();

  /**
   * Whether a model of the given type is known to the manager.
   *
   * @param string $id
   *   The type.
   *
   * @return bool
   *   TRUE if the manager is aware of a model with
   *   the given type. FALSE otherwise.
   */
  public function has($id);

  /**
   * Retrieve the subject with the given ID.
   *
   * @param string $id
   *   A string.
   *
   * @return \Trupal\Core\Subject\SubjectInterface
   *   A subject instance.
   */
  public function get($id);

}
