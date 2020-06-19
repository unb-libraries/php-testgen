<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\FileFormatValidationFilter;

/**
 * Discovery of subject definition files.
 *
 * @package Tozart\Discovery
 */
class SubjectDiscovery extends DiscoveryBase {

  /**
   * Create a new SubjectDiscovery instance.
   *
   * @param array $directories
   *   An array of directories or paths.
   * @param \Tozart\os\FileType $file_type
   *   A file type indicating the format which
   *   subjects should be declared in.
   */
  public function __construct(array $directories, $file_type) {
    parent::__construct($directories, [
      new FileFormatValidationFilter($file_type),
    ]);
  }

}
