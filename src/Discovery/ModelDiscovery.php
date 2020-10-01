<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\DirectoryFilterFactoryTrait;
use Tozart\os\FileTypeInterface;

/**
 * Discovery for model definition files.
 *
 * @package Tozart\Subject
 */
class ModelDiscovery extends DiscoveryBase {

  use DirectoryFilterFactoryTrait;

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
      static::directoryFilterFactory()->create('file_format', ['file_type' => $file_type]),
      static::directoryFilterFactory()->create('model', ['file_type' => $file_type]),
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
