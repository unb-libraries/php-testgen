<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\FileFormatValidationFilter;
use Tozart\Discovery\Filter\ModelValidationFilter;
use Tozart\os\FileTypeInterface;

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
   * @param \Tozart\os\FileTypeInterface $file_type
   *   A file type indicating the format which
   *   models should be declared in.
   */
  public function __construct(array $directories, FileTypeInterface $file_type) {
    $filters = [
      new FileFormatValidationFilter($file_type),
      new ModelValidationFilter($file_type),
    ];
    parent::__construct($directories, $filters);
  }

  /**
   * {@inheritDoc}
   */
  public function findBy($key) {
    foreach ($this->discover() as $file_path => $file) {
      /** @var \Tozart\os\File $file */
      $model_specification = $file->parse();
      if ($model_specification['type'] === $key) {
        return $model_specification;
      }
    }
    return FALSE;
  }

}
