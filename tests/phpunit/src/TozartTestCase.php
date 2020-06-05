<?php

namespace Tozart\Test;

use PHPUnit\Framework\TestCase;
use Tozart\os\DependencyInjection\FileSystemTrait;
use Tozart\Tozart;

/**
 * Base test case for all Tozart tests.
 *
 * @package Tozart\Test
 */
abstract class TozartTestCase extends TestCase {

  use FileSystemTrait;

  /**
   * A Tozart instance.
   *
   * @var \Tozart\Tozart
   */
  protected $_tozart;

  /**
   * Retrieve a Tozart instance.
   *
   * @return \Tozart\Tozart
   *   A Tozart instance.
   */
  protected function tozart() {
    if (!isset($this->_tozart)) {
      $this->_tozart = Tozart::create();
    }
    return $this->_tozart;
  }

  /**
   * Retrieve the model root path.
   *
   * @return \Tozart\os\Directory
   *   A directory object.
   */
  protected function modelRoot() {
    return $this
      ->tozart()
      ->modelRoot();
  }

  /**
   * Retrieve the subject root path.
   *
   * @return \Tozart\os\Directory
   *   A directory object.
   */
  protected function subjectRoot() {
    return $this
      ->tozart()
      ->subjectRoot();
  }

  /**
   * Retrieve the template root path.
   *
   * @return \Tozart\os\Directory
   *   A directory object.
   */
  protected function templateRoot() {
    return $this
      ->tozart()
      ->templateRoot();
  }

}
