<?php

namespace Tozart\os\parse;

use Tozart\os\File;

/**
 * Interface for file parser implementations.
 *
 * @package Tozart\os\parse
 */
interface FileParserInterface {

  /**
   * Retrieve the file's content in a structured form.
   *
   * @param \Tozart\os\File $file
   *   The file to parse.
   *
   * @return mixed
   *   The parsed content.
   */
  public function parse(File $file);

  /**
   * Retrieve the file types this parser can process.
   *
   * @return \Tozart\os\FileTypeInterface[]
   *   An array of file types.
   */
  public function getSupportedTypes();

}
