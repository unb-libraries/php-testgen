<?php

namespace Tozart\os;

use Tozart\os\DependencyInjection\FileParsingTrait;
use Tozart\validate\FileFormatValidator;

abstract class FileFormatValidationFilter implements DirectoryFilterInterface {

  protected $_validator;

  protected function validator() {
    return $this->_validator;
  }

  public function __construct($file_type) {
    $this->_validator = new FileFormatValidator($file_type);
  }

  public function match(File $file) {
    return empty($this->validator()->validate($file)) ? 1: 0;
  }

}
