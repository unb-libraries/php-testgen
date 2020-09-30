<?php

namespace Tozart\Validation;

use Tozart\os\File;
use Tozart\os\FileTypeInterface;

/**
 * Validator of file formats.
 *
 * @package Tozart\Validation
 */
class FileFormatValidator implements ValidatorInterface {

  /**
   * The file type that determines the expected format for validation.
   *
   * @var \Tozart\os\FileTypeInterface
   */
  protected $_fileType;

  /**
   * Retrieve the file type that determines the expected format for validation.
   *
   * @return \Tozart\os\FileTypeInterface
   *   A file type object.
   */
  public function getFileType() {
    return $this->_fileType;
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'file_format';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [
      'file_type' => 'yml',
    ];
  }

  /**
   * Create anew FileFormatValidator instance.
   *
   * @param \Tozart\os\FileTypeInterface $file_type
   *   A file type object to determine the expected format for validation.
   */
  public function __construct(FileTypeInterface $file_type) {
    $this->_fileType = $file_type;
  }

  /**
   * {@inheritDoc}
   */
  public static function create($configuration) {
    return new static($configuration['file_type']);
  }

  /**
   * {@inheritDoc}
   */
  public function validate($object) {
    $errors = [];
    if (!($object instanceof File)) {
      // TODO: Use logging service to log errors.
      $errors[] = sprintf('FileFormatValidators expect input of type %s, %s given.',
        File::class, get_class($object));
    }
    elseif (!$object->type()) {
      $errors[] = sprintf('Unknown file type: %s', $object->path());
    }
    elseif (!$object->type()->equals($this->getFileType())) {
      $errors[] = sprintf('File of type %s expected, %s given.',
        $this->getFileType()->getName(), $object->type()->getName());
    }
    elseif (!$this->canParse($object)) {
      $errors[] = sprintf('File could not be parsed.');
    }

    return $errors;
  }

  /**
   * Whether a parser exists for the given file.
   *
   * @param \Tozart\os\File $file
   *   The file.
   *
   * @return bool
   *   TRUE if the file can be parsed, i.e. a parser
   *   that can process the file does exist.
   *   FALSE otherwise.
   */
  protected function canParse(File $file) {
    try {
      $this->getFileType()
        ->getParser()
        ->parse($file);
    }
    catch (\Exception $e) {
      return FALSE;
    }
    return TRUE;
  }

}
