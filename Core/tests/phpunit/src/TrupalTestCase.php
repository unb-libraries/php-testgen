<?php

namespace Trupal\Core\Test;

use PHPUnit\Framework\TestCase;
use Trupal\Core\os\DependencyInjection\FileSystemTrait;
use Trupal\Core\Trupal;

/**
 * Base test case for all Trupal tests.
 *
 * @package Trupal\Core\Test
 */
abstract class TrupalTestCase extends TestCase {

  use FileSystemTrait;

  /**
   * A Trupal instance.
   *
   * @var \Trupal\Core\Trupal
   */
  protected $_trupal;

  /**
   * Retrieve a Trupal instance.
   *
   * @return \Trupal\Core\Trupal
   *   A Trupal instance.
   */
  protected function trupal() {
    if (!isset($this->_trupal)) {
      $this->_trupal = Trupal::create();
    }
    return $this->_trupal;
  }

  /**
   * Retrieve the model root path.
   *
   * @return \Trupal\Core\os\Directory
   *   A directory object.
   */
  protected function modelRoot() {
    return $this
      ->trupal()
      ->modelRoot();
  }

  /**
   * Retrieve the subject root path.
   *
   * @return \Trupal\Core\os\Directory
   *   A directory object.
   */
  protected function subjectRoot() {
    return $this
      ->trupal()
      ->subjectRoot();
  }

  /**
   * Retrieve the template root path.
   *
   * @return \Trupal\Core\os\Directory
   *   A directory object.
   */
  protected function templateRoot() {
    return $this
      ->trupal()
      ->templateRoot();
  }

}
