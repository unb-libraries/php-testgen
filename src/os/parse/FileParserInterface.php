<?php

namespace Tozart\os\parse;

/**
 * Interface for file parser implementations.
 *
 * @package Tozart\os\parse
 */
interface FileParserInterface {

  /**
   * The file types which this parser process.
   *
   * @return array
   *   An array of file type extensions.
   */
  public function fileTypes();

  /**
   * Retrieve the file's content in a structured form.
   *
   * @param \Tozart\os\File $file
   *   The file to parse.
   *
   * @return mixed
   *   The parsed content.
   */
  public function parse($file);

}
