<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\FileTypeInterface;
use Tozart\Validation\ModelValidator;

class ModelValidationFilter extends FileFormatValidationFilter {

  public function __construct(FileTypeInterface $file_type) {
    parent::__construct($file_type);
    $this->_validator = new ModelValidator($file_type);
  }

}
