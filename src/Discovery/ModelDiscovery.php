<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\FileFormatValidationFilter;
use Tozart\Discovery\Filter\ModelValidationFilter;

/**
 * Discovery for model definition files.
 *
 * @package Tozart\Subject
 */
class ModelDiscovery extends DiscoveryBase {

  /**
   * Create a new SubjectModelLocator instance.
   *
   * @param array $directories
   *   An array of directories or paths.
   * @param \Tozart\os\FileType $file_type
   *   A file type indicating the format which
   *   models should be declared in.
   */
  public function __construct(array $directories, $file_type) {
    $filters = [
      new FileFormatValidationFilter($file_type),
      new ModelValidationFilter($file_type),
    ];
    parent::__construct($directories, $filters);
  }

}
