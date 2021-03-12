<?php

namespace Trupal\Core\os\DependencyInjection;

use Trupal\Core\Trupal;

/**
 * Dependency injection for file parsers.
 *
 * @package Trupal\Core\os\DependencyInjection
 */
trait FileParsingTrait {

  /**
   * Inject a file parser of the given type.
   *
   * @param string $type
   *   A file type.
   *
   * @return \Trupal\Core\os\parse\FileParserInterface|null
   *   A file parser object.
   */
  public static function parser(string $type) {
    return Trupal::fileParserManager()
      ->getParser($type);
  }

}
