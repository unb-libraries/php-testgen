<?php

namespace Tozart\Validation;

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
    $parsed_content = $this->tryParse($object);
    return is_array($parsed_content) && !empty($parsed_content);
  }

  /**
   * Try to parse the given object.
   *
   * @param mixed $object
   *   The object, supposedly a file.
   *
   * @return array|null
   *   The parsed content. NULL if the object
   *   could not be parsed.
   */
  protected function tryParse($object) {
    try {
      if ($parser = $this->getFileType()->getParser()) {
        return $parser->parse($object);
      }
      return NULL;
    }
    catch (\Exception $e) {
      // TODO: Log the unexpected behaviour.
      return NULL;
    }
  }

}
