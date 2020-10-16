<?php

namespace Tozart\Validation;

use Tozart\os\parse\FileParserInterface;

/**
 * Validator of file formats.
 *
 * @package Tozart\Validation
 */
class FileFormatValidator implements ValidatorInterface {

  /**
   * The parser to determine a file's format validity.
   *
   * @var \Tozart\os\parse\FileParserInterface
   */
  protected $_parser;

  /**
   * Retrieve the file type that determines the expected format for validation.
   *
   * @return \Tozart\os\parse\FileParserInterface
   *   A file type object.
   */
  public function getParser() {
    return $this->_parser;
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
      'parser' => 'yml',
    ];
  }

  /**
   * Create anew FileFormatValidator instance.
   *
   * @param \Tozart\os\parse\FileParserInterface $parser
   *   A file parser.
   */
  public function __construct(FileParserInterface $parser) {
    $this->_parser = $parser;
  }

  /**
   * {@inheritDoc}
   */
  public static function create($configuration) {
    return new static($configuration['parser']);
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
      return $this->getParser()
        ->parse($object);
    }
    catch (\Exception $e) {
      // TODO: Log the unexpected behaviour.
      return NULL;
    }
  }

}
