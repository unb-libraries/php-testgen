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

    // TODO: Test that, if dir1 contains no matches, only files from dir2 are returned.
    $this->assertCount(2, $directories);
    $this->assertCount(3, $files);

    $locator->stackFilter(new AlwaysRejectFilter());
    $this->assertCount(0, $locator->find());
  }

  /**
   * Test that the file the highest ranked file ist returned.
   */
  public function testGetHighestScoredFile() {
    $locator = new Locator(static::$dirs, [
      new RandomPassFilter(),
    ]);

    $files = $locator->find();
    $most_important_dir = $files[array_keys($files)[0]];
    $best_match = array_keys($most_important_dir)[0];

    // TODO: Test that, even if dir2 contains higher scored matches, the highest-ranked from dir1 is returned.
    $this->assertEquals($best_match, $locator->get()->name());
  }

}