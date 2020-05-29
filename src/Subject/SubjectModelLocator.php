<?php

namespace Tozart\Subject;

use Tozart\os\FileTypeFilter;
use Tozart\os\Locator;
use Tozart\os\SubjectModelValidationFilter;

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
   * @param array $file_types
   *   An array of file types indicating the
   *   file format which models should be declared in.
   */
  public function __construct(array $directories, $file_types = []) {
    $filters = [];
    if (!empty($file_types)) {
      $filters[] = new FileTypeFilter($file_types);
      // TODO: Allow only one file_type.
      // TODO: Create file type class to associate several file extensions with one file type.
      $filters[] = new SubjectModelValidationFilter($file_types[array_keys($file_types)[0]]);
    }
    parent::__construct($directories, $filters);
  }

}
