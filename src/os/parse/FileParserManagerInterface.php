<?php

namespace Trupal\os\parse;

/**
 * Interface for file parser managers.
 *
 * @package Trupal\os\parse
 */
interface FileParserManagerInterface {

  /**
   * Retrieve all available file parsers.
   *
   * @return \Trupal\os\parse\FileParserInterface[]
   *   An array of file parser instances.
   */
  public function parsers();
  /**
   * Add the given file parser.
   *
   * @param \Trupal\os\parse\FileParserInterface $parser
   *   A file parser object.
   */
  public function addParser(FileParserInterface $parser);
  /**
   * Retrieve a parser which can process the given file type.
   *
   * @param string $id
   *   A file type name.
   *
   * @return \Trupal\os\parse\FileParserInterface|null
   *   A file parser object, if one exists to parse
   *   the given type.
   */
  public function getParser(string $id);

  /**
   * Retrieve the file's content in a structured form.
   *
   * @param \Trupal\os\FileInterface|string $file
   *   The file to parse.
   *
   * @return mixed
   *   The parsed content.
   */
  public function parse($file);

}
