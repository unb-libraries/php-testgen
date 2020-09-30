<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\FileTypeInterface;
use Tozart\Validation\ModelValidator;

/**
 * Filter for sorting out invalid model specifications.
 *
 * @package Tozart\Discovery\Filter
 */
class ModelValidationFilter extends FileFormatValidationFilter {

  /**
   * Create a new ModelValidationFilter instance.
   *
   * @param \Tozart\os\FileTypeInterface $file_type
   *   The file type of which model specification files must be.
   */
  public function __construct(FileTypeInterface $file_type) {
    parent::__construct($file_type);
    $this->_validator = new ModelValidator($file_type);
  }

}
