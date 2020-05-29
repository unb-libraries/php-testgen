<?php

namespace Tozart\os;

/**
 * Describes features of file types.
 *
 * @package Tozart\os
 */
class FileType {

  /**
   * The name of the file type.
   *
   * @var string
   */
  protected $_name;

  /**
   * A list of file extensions that can be associated with this file type.
   *
   * @var array
   */
  protected $_extensions;

  /**
   * A parser that processes files of this type.
   *
   * @var \Tozart\os\parse\FileParserInterface
   */
  protected $_parser;

  /**
   * Retrieve the name of the file type.
   *
   * @return string
   *   A string.
   */
  public function name() {
    return $this->_name;
  }

  /**
   * Retrieve the parser that processes files of this type.
   *
   * @return \Tozart\os\parse\FileParserInterface
   *   A file parser object.
   */
  public function parser() {
    return $this->_parser;
  }

  /**
   * Retrieve a list of file extensions that are associated with this type.
   *
   * @return array
   *   An array of strings.
   */
  public function extensions() {
    return $this->_extensions;
  }

  /**
   * Assign a list of extensions to this file type.
   *
   * @param array $extensions
   *   An array of file extensions strings.
   */
  protected function setExtensions($extensions) {
    $this->_extensions = array_map(function ($extension) {
      return strtolower($extension);
    }, $extensions);
  }

  /**
   * Create a new FileType instance.
   *
   * @param string $name
   *   A string.
   * @param array $extensions
   *   An array of file extension strings.
   * @param \Tozart\os\parse\FileParserInterface $parser
   *   (optional) A file parser instance.
   */
  public function __construct($name, array $extensions, $parser = NULL) {
    $this->_name = $name;
    $this->setExtensions($extensions);
    $this->_parser = $parser;
  }

  /**
   * Whether files of this type contain structured data that can be parsed.
   *
   * @return bool
   *   TRUE if a parser exists that can process files of this type.
   *   FALSE otherwise.
   */
  public function isStructured() {
    return !is_null($this->parser());
  }

}
