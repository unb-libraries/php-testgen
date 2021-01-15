<?php

namespace Trupal\os\parse;

use Trupal\os\DependencyInjection\FileSystemTrait;
use Trupal\Trupal;

/**
 * Manager of file parser instances.
 *
 * @package Trupal\os\parse
 */
class FileParserManager implements FileParserManagerInterface {

  use FileSystemTrait;

  /**
   * Available file parsers.
   *
   * @var \Trupal\os\parse\FileParserInterface[]
   */
  protected $_parsers;

  /**
   * Retrieve all available file parsers.
   *
   * @return \Trupal\os\parse\FileParserInterface[]
   *   An array of file parser instances.
   */
  public function parsers() {
    return $this->_parsers;
  }

  /**
   * Create a FileParserManager instance.
   *
   * @param array $parsers
   *   An array of file parsers.
   */
  public function __construct(array $parsers) {
    foreach ($parsers as $parser) {
      $this->addParser($parser);
    }
  }

  /**
   * Add the given file parser.
   *
   * @param \Trupal\os\parse\FileParserInterface $parser
   *   A file parser object.
   */
  public function addParser(FileParserInterface $parser) {
    $this->_parsers[$parser->getId()] = $parser;
  }

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
  public function getParser(string $id) {
    if (array_key_exists($id, $parsers = $this->parsers())) {
      return $parsers[$id];
    }
    return NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function parse($file) {
    if (is_string($file)) {
      $file = static::fileSystem()->file($file, '', TRUE);
    }

    if ($parser = $this->getParser($file->type()->getName())) {
      return $parser->parse($file->path());
    }
    return FALSE;
  }

}
