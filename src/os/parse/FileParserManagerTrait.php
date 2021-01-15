<?php

namespace Trupal\os\parse;

use Trupal\Trupal;

/**
 * Provides dependency injection for the file parser manager service.
 *
 * @package Trupal\os\parse
 */
trait FileParserManagerTrait {

  /**
   * Inject the file parser manager service.
   *
   * @return \Trupal\os\parse\FileParserManagerInterface
   *   A file parser manager object.
   */
  protected static function parserManager() {
    return Trupal::fileParserManager();
  }

}
