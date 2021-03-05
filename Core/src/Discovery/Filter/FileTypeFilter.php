<?php

namespace Trupal\Core\Discovery\Filter;

use Trupal\os\FileTypeInterface;

/**
 * Filter for sorting out files are of a file type different to the configured.
 *
 * @package Trupal\Discovery\Filter
 */
class FileTypeFilter extends FileNamePatternFilter {

  /**
   * The file type by which to filter.
   *
   * @var \Trupal\os\FileTypeInterface
   */
  protected $_fileType;

  /**
   * Retrieve the file type by which to filter.
   *
   * @return \Trupal\os\FileTypeInterface
   *   A file type object.
   */
  public function fileType() {
    return $this->_fileType;
  }

  /**
   * Create a new FileTypeFilter instance.
   *
   * @param \Trupal\os\FileTypeInterface $file_type
   *   A file type object.
   */
  public function __construct(FileTypeInterface $file_type) {
    $this->_fileType = $file_type;
    parent::__construct($this->buildPattern());
  }

  /**
   * {@inheritDoc}
   */
  public static function create(array $configuration) {
    return new static($configuration['file_type']);
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'file_type';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [
      'file_type' => 'yml',
    ];
  }

  /**
   * Build the pattern that validates the filename.
   *
   * @return string
   *   A regular expression string.
   */
  protected function buildPattern() {
    $extensions = $this->fileType()->getExtensions();
    return str_replace('@extensions',
      implode('|', $extensions), '/.*\.(@extensions)$/');
  }

}
