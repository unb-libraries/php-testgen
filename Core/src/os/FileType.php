<?php

namespace Trupal\Core\os;

use Trupal\Core\os\parse\FileParserInterface;

/**
 * Describes features of file types.
 *
 * @package Trupal\Core\os
 */
class FileType implements FileTypeInterface {

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
   * @var \Trupal\Core\os\parse\FileParserInterface
   */
  protected $_parser;

  /**
   * {@inheritDoc}
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set a name for the file type.
   *
   * @param string $name
   *   A string.
   */
  protected function setName($name) {
    $this->_name = strtolower($name);
  }

  /**
   * {@inheritDoc}
   */
  public function getParser() {
    return $this->_parser;
  }

  /**
   * {@inheritDoc}
   */
  public function getExtensions() {
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
   * @param \Trupal\Core\os\parse\FileParserInterface|null $parser
   *   (optional) A file parser instance.
   */
  public function __construct(string $name, array $extensions, FileParserInterface $parser = NULL) {
    $this->_name = strtolower($name);
    $this->setExtensions($extensions);
    $this->_parser = $parser;
  }

  /**
   * {@inheritDoc}
   */
  public function isStructured() {
    return !is_null($this->getParser());
  }

  /**
   * {@inheritDoc}
   */
  public function equals(FileTypeInterface $file_type) {
    $shared_extensions = array_intersect(
      $this->getExtensions(), $file_type->getExtensions());
    return count($shared_extensions) == count($this->getExtensions());
  }

}
