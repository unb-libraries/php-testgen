<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\File;
use Tozart\Validation\FileFormatValidator;

class FileFormatValidationFilter implements DirectoryFilterInterface {

  protected $_fileType;
  protected $_validator;

  protected function fileType() {
    return $this->_fileType;
  }

  protected function validator() {
    if (!isset($this->_validator)) {
      $this->_validator = new FileFormatValidator($this->fileType());
    }
    return $this->_validator;
  }

  public function __construct($file_type) {
    $this->_fileType = $file_type;
  }

  public function match(File $file) {
    $errors = $this->validator()
      ->validate($file);
    return empty($errors) ? 1.0 : 0.0;
  }

}
