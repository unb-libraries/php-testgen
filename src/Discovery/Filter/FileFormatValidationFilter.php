<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\File;
use Tozart\Validation\FileFormatValidator;
use Tozart\os\FileTypeInterface;

class FileFormatValidationFilter extends FileTypeFilter {

  protected $_validator;

  protected function validator() {
    return $this->_validator;
  }

  public function __construct(FileTypeInterface $file_type) {
    parent::__construct($file_type);
    $this->_validator = new FileFormatValidator($file_type);
  }

  public function match(File $file) {
    if ($pass = parent::evaluate($file)) {
      $pass = empty($validation_errors = $this->validator()
        ->validate($file));
    }
    return $pass;
  }

}
