<?php

namespace Tozart\Test\os;

use PHPUnit\Framework\TestCase;
use Tozart\os\DependencyInjection\FileSystemTrait;

abstract class FileSystemTestCase extends TestCase {

  use FileSystemTrait;

  /**
   * Root path at which to create test folders.
   */
  private const TEST_ROOT = __DIR__ . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;

  protected static function root() {
    return self::TEST_ROOT;
  }

  /**
   * Overrides @see TestCase::setUpBeforeClass()
   *
   * Create a temporary folder in which to test creating test folders.
   */
  public static function setUpBeforeClass(): void {
    parent::setUpBeforeClass();
    \mkdir(self::root(), 0777, TRUE);
  }

  /**
   * Overrides @see TestCase::tearDown()
   *
   * Remove the test root created during setUp().
   */
  protected function tearDown(): void {
    parent::tearDown();
    $this->clearDirectory(self::root());
  }

  /**
   * Remove all contents from the folder at the given path.
   *
   * @param string $path
   *   The path at which to find the folder to clear.
   * @param bool $remove
   *   Whether to also remove the folder, which is to be cleared.
   */
  protected function clearDirectory($path, $remove = FALSE) {
    foreach (new \DirectoryIterator($path) as $item) {
      $filepath = $item->getPath() . DIRECTORY_SEPARATOR . $item->getFilename();
      if ($item->isDir() && !$item->isDot()) {
        $this->clearDirectory($filepath, TRUE);
      }
      elseif ($item->isFile()) {
        \unlink($filepath);
      }
    }

    if ($remove) {
      \rmdir($path);
    }
  }

  /**
   * Overrides @see TestCase::tearDownAfterClass()
   *
   * Remove the test root.
   */
  public static function tearDownAfterClass(): void {
    parent::tearDownAfterClass();
    \rmdir(self::root());
  }

}