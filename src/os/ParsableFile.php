<?php

namespace TestGen\os;

/**
 * Class to process a structured, parsable file.
 *
 * @package TestGen\os
 */
abstract class ParsableFile extends File {

  /**
   * Parse into a data structure.
   *
   * @return mixed
   */
  abstract public function parse();

}
