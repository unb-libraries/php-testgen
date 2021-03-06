<?php

namespace Trupal\Core\os;

/**
 * Interface for file type definitions.
 *
 * @package Trupal\Core\os
 */
interface FileTypeInterface {

  /**
   * Retrieve the name of the file type.
   *
   * @return string
   *   A string.
   */
  public function getName();

  // TODO: Decouple file types and parsers: file types should be able to exist independently of parsers.
  /**
   * Retrieve the parser that processes files of this type.
   *
   * @return \Trupal\Core\os\parse\FileParserInterface
   *   A file parser object.
   */
  public function getParser();

  /**
   * Retrieve a list of file extensions that are associated with this type.
   *
   * @return array
   *   An array of strings.
   */
  public function getExtensions();

  /**
   * Whether files of this type contain structured data that can be parsed.
   *
   * @return bool
   *   TRUE if a parser exists that can process files of this type.
   *   FALSE otherwise.
   */
  public function isStructured();

  /**
   * Whether the given file type is equivalent to this one.
   *
   * @param \Trupal\Core\os\FileTypeInterface $file_type
   *   The file type to compare.
   *
   * @return bool
   *   TRUE if the
   */
  public function equals(FileTypeInterface $file_type);

}
