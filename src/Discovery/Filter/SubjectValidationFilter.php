<?php

namespace Tozart\Discovery\Filter;

use Tozart\Validation\SubjectValidator;

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
  public function __construct($file_type) {
    parent::__construct($file_type);
    $this->_validator = new SubjectValidator($file_type);
  }

}
