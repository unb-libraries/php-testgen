<?php

namespace Trupal\Subject;

/**
 * Subject of type "Form".
 *
 * @package Trupal\Subject
 */
class Form extends Page {

  /**
   * The destination path of a successful form submission.
   *
   * @var string
   */
  protected $destination;

  /**
   * The fields that make the form.
   *
   * @var array
   */
  protected $fields;

  /**
   * Retrieve the destination path of a successful form submission.
   *
   * @return string
   *   A string of the form "/redirect/here/upon/submission".
   */
  public function getDestination() {
    return $this->destination;
  }

  /**
   * @param string $path
   *   A string of the form "/redirect/here/upon/submission".
   */
  public function setDestination(string $path) {
    $this->destination = $path;
  }

  /**
   * Retrieve the fields that make the form.
   *
   * @return array
   *   An array of field names.
   */
  public function getFields() {
    return $this->fields;
  }

}
