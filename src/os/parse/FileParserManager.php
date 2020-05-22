<?php

namespace Tozart\os\parse;

class FileParserManager {

  /**
   * Available file parsers.
   *
   * @var \Tozart\os\parse\FileParserInterface[]
   */
  protected $_parsers;

  /**
   * Retrieve all available file parsers.
   *
   * @return \Tozart\os\parse\FileParserInterface[]
   *   An array of file parser instances.
   */
  public function parsers() {
    return $this->_parsers;
  }

  public function __construct(array $parsers) {
    foreach ($parsers as $parser) {
      $this->addParser($parser);
    }
  }

  public function addParser(FileParserInterface $parser) {
    $supported_types = $parser->fileTypes();
    $this->_parsers[$supported_types[0]] = $parser;
  }

  public function getParser($type) {
    foreach ($this->parsers() as $parser) {
      if (in_array($type, $parser->fileTypes())) {
        return $parser;
      }
    }
    return NULL;
  }

}
