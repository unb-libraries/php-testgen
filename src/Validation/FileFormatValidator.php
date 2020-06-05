<?php

namespace Tozart\Validation;

use Tozart\os\File;

class FileFormatValidator implements ValidatorInterface {

//  use FileParsingTrait;

  protected $_fileType;

  public function fileType() {
    return $this->_fileType;
  }

  public function __construct($file_type) {
    $this->_fileType = $file_type;
  }

  public function validate($object) {
    $errors = [];
    try {
      if (!($object instanceof File)) {
        // TODO: Use translation for string output.
        $errors[] = sprintf('FileFormatValidators expect input of type %s, %s given.',
          File::class, get_class($object));
      } else {
        $object->type()
          ->parser()
          ->parse($object);
      }
    }
    catch (\Exception $e) {
      $errors[] = sprintf('Input could not be parsed: %s', $e->getMessage());
    }
    finally {
      return $errors;
    }
  }

}
