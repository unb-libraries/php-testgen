<?php

namespace Tozart\Discovery\Filter;

use Tozart\Validation\SubjectModelValidator;

class SubjectModelValidationFilter extends FileFormatValidationFilter {

  public function __construct($file_type) {
    parent::__construct($file_type);
    $this->_validator = new SubjectModelValidator($file_type);
  }

}
