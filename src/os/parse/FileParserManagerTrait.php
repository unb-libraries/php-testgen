<?php

namespace Tozart\os\parse;

use Tozart\Tozart;

/**
 * Provides dependency injection for the file parser manager service.
 *
 * @package Tozart\os\parse
 */
trait FileParserManagerTrait {

  /**
   * Inject the file parser manager service.
   *
   * @return \Tozart\os\parse\FileParserManagerInterface
   *   A file parser manager object.
   */
  protected static function parserManager() {
    return Tozart::fileParserManager();
  }

}
