<?php

namespace Tozart\os\DependencyInjection;

use Tozart\Tozart;

/**
 * Dependency injection for file parsers.
 *
 * @package Tozart\os\DependencyInjection
 */
trait FileParsingTrait {

  /**
   * Inject a file parser of the given type.
   *
   * @param string $type
   *   A file type.
   *
   * @return \Tozart\os\parse\FileParserInterface|null
   *   A file parser object.
   */
  public static function parser(string $type) {
    return Tozart::fileParserManager()
      ->getParser($type);
  }

}
