<?php

namespace TestGen\Test;

use PHPUnit\Framework\TestCase;
use TestGen\os\Directory;

/**
 * Test creating and interacting with instances of the Directory class.
 *
 * @package TestGen\Test
 */
class DirectoryTest extends TestCase {

  /**
   * Root path at which to create test folders.
   */
  const TEST_ROOT = __DIR__ . '/../tmp/';

  /**
   * Overrides @see TestCase::setUpBeforeClass()
   *
   * Create a temporary folder in which to test creating test folders.
   */
  public static function setUpBeforeClass(): void {
    parent::setUpBeforeClass();
    \mkdir(self::TEST_ROOT, 0777, TRUE);
  }

  /**
   * Any directory instance must reflect an existing filesystem folder.
   */
  public function testDirectoryExists() {
    $path = self::TEST_ROOT . 'testgen';
    $directory = new Directory($path);
    $this->assertDirectoryExists($path);
  }

  /**
   * A directory instance must not any corrupt filesystem content.
   */
  public function testDirectoryIsIntact() {
    // TODO: Implement this.
    $this->markTestIncomplete("To be tested: 
      Directory instances must not any corrupt filesystem content.");
  }

  /**
   * Absolute directory paths must end with an OS dependent separator.
   */
  public function testAbsolutePathEndsWithSeparator() {
    // TODO: Implement this.
    $this->markTestIncomplete("To be tested: 
      Absolute directory paths must end with an OS dependent separator.");
  }

  /**
   * Local directory paths must ebd with an OS dependent separator.
   */
  public function testLocalPathEndsWithSeparator() {
    // TODO: Implement this.
    $this->markTestIncomplete("To be tested: 
      Local directory paths must ebd with an OS dependent separator.");
  }

  /**
   * A directory's parent must reflect its absolute path without its local.
   */
  public function testParentDirectoryPath() {
    // TODO: Implement this.
    $this->markTestIncomplete("To be tested: 
      A directory's parent must reflect its absolute path without its local.");
  }

  /**
   * Creating a directory instance must assign permissions implicitly.
   *
   * Implicit permissions must reflect a directory's parent's
   * file system permissions.
   */
  public function testImplicitPermissions() {
    // TODO: Implement this.
    $this->markTestIncomplete("To be tested: 
      Creating a directory instance must assign permissions implicitly.");
  }

  /**
   * Explicitly assigned permissions must reflect filesystem permissions.
   */
  public function testExplicitPermissions() {
    // TODO: Implement this.
    $this->markTestIncomplete("To be tested: 
      Explicitly assigned permissions must reflect filesystem permissions.");
  }

  /**
   * Overrides @see TestCase::tearDown()
   *
   * Remove the test root created during setUp().
   */
  protected function tearDown(): void {
    parent::tearDown();
    $this->clearDirectory(self::TEST_ROOT);
  }

  /**
   * Remove all contents from the folder at the given path.
   *
   * @param string $path
   *   The path at which to find the folder to clear.
   * @param bool $remove
   *   Whether to remove the to be cleared folder itself.
   */
  protected function clearDirectory($path, $remove = FALSE) {
    foreach (new \DirectoryIterator($path) as $item) {
      if ($item->isDir() && !$item->isDot()) {
        $this->clearDirectory(
          $item->getPath() . '/' . $item->getFilename(), TRUE
        );
      }
      elseif ($item->isFile()) {
        \unlink($item->getPath());
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
    \rmdir(self::TEST_ROOT);
  }

}
