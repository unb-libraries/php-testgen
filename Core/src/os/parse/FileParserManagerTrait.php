<?php

namespace Trupal\Core\os\parse;

use Trupal\Core\Trupal;

/**
 * Provides dependency injection for the file parser manager service.
 *
 * @package Trupal\Core\os\parse
 */
trait FileParserManagerTrait {

  /**
   * Inject the file parser manager service.
   *
   * @return \Trupal\Core\os\parse\FileParserManagerInterface
   *   A file parser manager object.
   */
  protected static function parserManager() {
    return Trupal::fileParserManager();
  }

}
