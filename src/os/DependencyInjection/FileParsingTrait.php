<?php

namespace Tozart\os\DependencyInjection;

use Tozart\Tozart;

trait FileParsingTrait {

  /**
   * Retrieve file parser for the given file type.
   *
   * @param string $type
   *   A file type.
   *
   * @return \Tozart\os\parse\FileParserInterface|null
   *   A file parser object.
   */
  public static function parser($type) {
    return Tozart::fileParserManager()
      ->getParser($type);
  }

}
