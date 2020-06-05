<?php

namespace Tozart\Validation;

use Tozart\os\File;

class FileFormatValidator implements ValidatorInterface {

  protected $_fileType;

  /**
   * @return \Tozart\os\FileType
   */
  public function fileType() {
    return $this->_fileType;
  }

  public function __construct($file_type) {
    $this->_fileType = $file_type;
  }

  public function validate($object) {
    $errors = [];
    if (!($object instanceof File)) {
      // TODO: Use translation for string output.
      $errors[] = sprintf('FileFormatValidators expect input of type %s, %s given.',
        File::class, get_class($object));
    }
    elseif (!$object->type()) {
      $errors[] = sprintf('Unknown file type: %s', $object->path());
    }
    elseif (!$object->type()->equals($this->fileType())) {
      $errors[] = sprintf('File of type %s expected, %s given.',
        $this->fileType()->name(), $object->type()->name());
    }
    elseif (!$this->canParse($object)) {
      $errors[] = sprintf('File could not be parsed.');
    }

    return $errors;
  }

  protected function canParse(File $file) {
    try {
      $this->fileType()
        ->parser()
        ->parse($file);
    }
    catch (\Exception $e) {
      return FALSE;
    }
    return TRUE;
  }

}
