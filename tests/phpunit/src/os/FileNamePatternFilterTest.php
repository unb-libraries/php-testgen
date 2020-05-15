<?php

namespace Tozart\Test\os;

use Tozart\os\FileNamePatternFilter;

/**
 * Test class for FileNamePatternFilter implementation.
 *
 * @package Tozart\Test\os
 */
class FileNamePatternFilterTest extends DirectoryFilterTestCase {

  /**
   * An array of files.
   *
   * @var \Tozart\os\File
   */
  protected static $files = [];

  /**
   * Overrides @see \Tozart\Test\os\FileSystemTestCase::setUpBeforeClass()
   *
   * Put test files into the temp folder.
   */
  public static function setUpBeforeClass(): void {
    parent::setUpBeforeClass();
    $root = static::fileSystem()->dir(static::root());
    foreach (['file.yml', 'file.json', 'file.xml', 'file.tmp'] as $filename) {
      static::$files[$filename] = $root->put($filename);
    }
  }

  /**
   * {@inheritDoc}
   */
  public function testMatch() {
    $root = static::fileSystem()->dir(static::root());
    $filter = new FileNamePatternFilter([
      "/.*\.yml/",
      "/.*\.json/",
      "/.*\.xml/",
    ]);

    $this->assertEquals(1.0, $filter->match($root->find('file.yml')));
    $this->assertEquals(2/3, $filter->match($root->find('file.json')));
    $this->assertEquals(1/3, $filter->match($root->find('file.xml')));
    $this->assertEquals(0, $filter->match($root->find('file.tmp')));
  }

}
