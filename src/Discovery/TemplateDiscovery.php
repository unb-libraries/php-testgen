<?php

namespace Tozart\Discovery;

use Tozart\Discovery\Filter\FileTypeFilter;
use Tozart\os\FileTypeInterface;

/**
 * Discovery of templates.
 *
 * @package Tozart\render
 */
class TemplateDiscovery extends DiscoveryBase {

  /**
   * Creates a new TemplateDiscovery instance.
   *
   * @param array $directories
   *   An array of directories or directory paths.
   * @param \Tozart\os\FileTypeInterface $file_type
   *   The file type of which template files must be.
   *
   * @see \Tozart\render\TemplateDiscovery::compilePattern().
   */
  public function __construct(array $directories, FileTypeInterface $file_type) {
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
