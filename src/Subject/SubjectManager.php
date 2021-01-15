<?php

namespace Trupal\Subject;

use Trupal\Discovery\FactoryInterface;

/**
 * Manager of subject instances.
 *
 * @package Trupal\Subject
 */
class SubjectManager implements SubjectManagerInterface {

  /**
   * The subjects.
   *
   * @var \Trupal\Subject\SubjectInterface[]
   */
  protected $_subjects = [];

  /**
   * The subject factory.
   *
   * @var \Trupal\Discovery\FactoryInterface
   */
  protected $_factory;

  /**
   * {@inheritDoc}
   */
  public function subjects() {
    return $this->_subjects;
  }

  /**
   * The subject factory.
   *
   * @return \Trupal\Discovery\FactoryInterface
   *   A subject factory instance.
   */
  protected function factory() {
    return $this->_factory;
  }

  /**
   * Create a new subject manager instance.
   *
   * @param \Trupal\Discovery\FactoryInterface $factory
   *   The subject factory.
   */
  public function __construct(FactoryInterface $factory) {
    $this->_factory = $factory;
  }

  /**
   * {@inheritDoc}
   */
  public function has($id) {
    return array_key_exists($id, $this->subjects());
  }

  /**
   * {@inheritDoc}
   */
  public function get($id) {
    if (!$this->has($id)) {
      if (!$subject = $this->factory()->create($id)) {
        return FALSE;
      }
      $this->add($subject);
    }
    return $this->subjects()[$id];
  }

  /**
   * Add (or replace) the given model.
   *
   * @param \Trupal\Subject\SubjectInterface $subject
   *   A model instance.
   * @param bool $replace
   *   Whether an existing model should be replaced.
   */
  protected function add(SubjectInterface $subject, $replace = TRUE) {
    if ($replace || !$this->has($subject->getId())) {
      $this->_subjects[$subject->getId()] = $subject;
    }
  }

}
