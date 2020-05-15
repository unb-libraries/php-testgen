<?php

namespace Tozart\Test\os;

use Tozart\os\Locator;

class LocatorTest extends FileSystemTestCase {

  protected static $dirs = [];

  public static function setUpBeforeClass(): void {
    parent::setUpBeforeClass();

    $dir1 = static::fileSystem()
      ->dir(static::root() . 'dir1');
    $dir1->put('file1');
    static::$dirs[] = $dir1;

    $dir2 = static::fileSystem()
      ->dir(static::root() . 'dir2');
    $dir2->put('file2');
    $dir2->put('file3');
    static::$dirs[] = $dir2;
  }

  /**
   * Test that all files that match the filter criteria are discovered.
   */
  public function testFindFiles() {
    $locator = new Locator(static::$dirs, [
      new AlwaysPassFilter(),
    ]);

    $files = [];
    foreach ($directories = $locator->find() as $directory) {
      foreach (array_keys($directory) as $filename) {
        $files[] = $filename;
      }
    }

    $this->assertCount(2, $directories);
    $this->assertCount(3, $files);

    $locator->stackFilter(new AlwaysRejectFilter());
    $this->assertCount(0, $locator->find());
  }

  /**
   * Test that the file the highest ranked file ist returned.
   */
  public function testGetHighestScoredFile() {
    $this->markTestIncomplete();
  }

}