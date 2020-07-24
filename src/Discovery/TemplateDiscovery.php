<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\FileTypeFilter;
use Tozart\os\FileType;

/**
 * A TemplateLocator finds suitable templates for subjects.
 *
 * @package Tozart\render
 */
class TemplateDiscovery extends DiscoveryBase {

  /**
   * Creates a new TemplateDiscovery instance.
   *
   * @param array $directories
   *   An array of directories or directory paths.
   * @param \Tozart\os\FileType $file_type
   *   A file type indicating the format which
   *   models should be declared in.
   *
   * @see \Tozart\render\TemplateDiscovery::compilePattern().
   */
  public function __construct(array $directories, FileType $file_type) {
    parent::__construct($directories, [
      new FileTypeFilter($file_type)
    ]);
  }

  /**
   * {@inheritDoc}
   */
  public function findBy($key) {
    /** @var \Tozart\Subject\SubjectInterface $subject */
    $subject = $key;
    foreach ($this->discover() as $dir => $files) {
      foreach ($files as $file_path => $file) {
        /** @var \Tozart\os\File $file */
        foreach ($subject->getTemplateDiscoveryPatterns() as $pattern) {
          if (preg_match($pattern, $file_path)) {
            return $file;
          }
        }
      }
    }
    return FALSE;
  }

}
