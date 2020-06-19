<?php

namespace Tozart\Discovery\Filter;

use Tozart\Validation\ModelValidator;

class ModelValidationFilter extends FileFormatValidationFilter {

  public function __construct($file_type) {
    parent::__construct($file_type);
    $this->_validator = new ModelValidator($file_type);
  }

}
