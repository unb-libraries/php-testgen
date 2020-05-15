<?php

namespace Tozart\Test\os;

/**
 * DirectoryFilter implementations should extend this class to be tested.
 *
 * @package Tozart\Test\os
 */
abstract class DirectoryFilterTestCase extends FileSystemTestCase {

  /**
   * Test that applying a filter to a given file produces the expected score.
   */
  abstract public function testMatch();

}
