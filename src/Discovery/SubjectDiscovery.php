<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\SubjectValidationFilter;
use Tozart\os\FileTypeInterface;

/**
 * Discovery of subject specifications.
 *
 * @package Tozart\Discovery
 */
class SubjectDiscovery extends DiscoveryBase {

  /**
   * Create a new SubjectDiscovery instance.
   *
   * @param array $directories
   *   An array of directories or paths.
   * @param \Tozart\os\FileTypeInterface $file_type
   *   The file type of which subject specification files must be.
   */
  public function __construct(array $directories, FileTypeInterface $file_type) {
    parent::__construct($directories, [
      new SubjectValidationFilter($file_type),
    ]);
  }

  /**
   * {@inheritDoc}
   */
  public function findBy($key) {
    foreach ($this->discover() as $file_path => $file) {
      /** @var \Tozart\os\FileInterface $file */
      $subject_specification = $file->parse();
      if ($subject_specification['id'] === $key) {
        return $subject_specification;
      }
    }
    return FALSE;
  }

}
