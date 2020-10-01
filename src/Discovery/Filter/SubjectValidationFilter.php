<?php

namespace Tozart\Discovery\Filter;

use Tozart\Validation\SubjectValidator;
use Tozart\os\FileTypeInterface;

/**
 * Filter for sorting out files which contain invalid subject specifications.
 *
 * @package Tozart\Discovery\Filter
 */
class SubjectValidationFilter extends FileFormatValidationFilter {

  /**
   * Create a new SubjectValidationFilter instance.
   *
   * @param \Tozart\os\FileTypeInterface $file_type
   *   The file type of which subject specification files must be.
   */
  public function __construct(FileTypeInterface $file_type) {
    parent::__construct($file_type);
    $this->_validator = new SubjectValidator($file_type);
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
    return 'subject';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [
      'file_type' => 'yml',
    ];
  }

}
