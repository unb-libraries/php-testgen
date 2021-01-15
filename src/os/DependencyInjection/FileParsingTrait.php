<?php

namespace Trupal\os\DependencyInjection;

use Trupal\Trupal;

/**
 * Dependency injection for file parsers.
 *
 * @package Trupal\os\DependencyInjection
 */
trait FileParsingTrait {

  /**
   * Inject a file parser of the given type.
   *
   * @param string $type
   *   A file type.
   *
   * @return \Trupal\os\parse\FileParserInterface|null
   *   A file parser object.
   */
  public static function parser(string $type) {
    return Trupal::fileParserManager()
      ->getParser($type);
  }

}
