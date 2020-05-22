<?php

namespace Tozart\Subject;

use Tozart\os\Locator;
use Tozart\os\YamlFilter;

/**
 * Locator to locate files that contain model definitions.
 *
 * @package Tozart\Subject
 */
class SubjectModelLocator extends Locator {

  /**
   * Create a new SubjectModelLocator instance.
   *
   * @param array $directories
   *   An array of directories or paths.
   */
  public function __construct(array $directories) {
    parent::__construct($directories, [new YamlFilter()]);

  }

}