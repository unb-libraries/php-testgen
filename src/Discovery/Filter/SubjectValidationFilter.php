<?php

namespace Tozart\Discovery\Filter;

use Tozart\Validation\SubjectValidator;

class SubjectValidationFilter extends FileFormatValidationFilter {

  public function __construct($file_type) {
    parent::__construct($file_type);
    $this->_validator = new SubjectValidator($file_type);
  }

}
