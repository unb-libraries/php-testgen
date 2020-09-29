<?php

namespace Tozart\Model;

class Model implements ModelInterface {

  protected $type;
  protected $subjectClass;
  protected $requirements;
  protected $options;

  public function __construct(array $model_description) {
    $this->type = $model_description['type'];
    $this->subjectClass = $model_description['class'];
    $this->requirements = array_key_exists('requirements', $model_description)
      ? $model_description['requirements']
      : [];
    $this->options = array_key_exists('options', $model_description)
      ? $model_description['options']
      : [];
  }

  public static function create(array $specification) {
    return new static($specification);
  }

  /**
   * {@inheritDoc}
   */
  public function getType() {
    return $this->type;
  }

  /**
   * {@inheritDoc}
   */
  public function getSubjectClass() {
    return $this->subjectClass;
  }

  /**
   * {@inheritDoc}
   */
  public function getRequirements() {
    return $this->requirements;
  }

  /**
   * {@inheritDoc}
   */
  public function getOptions() {
    return $this->options;
  }

  public function getProperties() {
    return array_merge(
        array_values($this->getRequirements()),
        $this->getOptions()
    );
  }

}
