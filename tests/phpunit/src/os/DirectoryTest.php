<?php

namespace Tozart\Test\os;

use Tozart\os\Directory;
use Tozart\os\File;

/**
 * Test creating and interacting with instances of the Directory class.
 *
 * @package Tozart\Test
 */
class DirectoryTest extends FileSystemTestCase {

  /**
   * Any directory instance must reflect an existing filesystem folder.
   */
  public function testDirectoryExists() {
    $path = self::root() . 'testgen';
    $directory = new Directory($path);
    $this->assertDirectoryExists($directory->systemPath());
  }

  /**
   * A directory instance must not any corrupt filesystem content.
   */
  public function testDirectoryIsIntact() {
    $dir_path = self::root() . 'testgen';
    $file_path1 = $dir_path . DIRECTORY_SEPARATOR . 'test1';

    \mkdir($dir_path, \fileperms(self::root()));
    \fopen($file_path1, 'x');
    new Directory($dir_path);

    $this->assertFileExists($file_path1);
  }

  /**
   * Existing directories must not have their permissions changed. New Directories must inherit their parent's permissions.
   */
  public function testPermissions() {
    $path = self::root() . 'dir1';
    $permissions = 0744;
    \mkdir($path, $permissions);

    $dir1 = new Directory($path);
    $dir2 = new Directory($dir1->systemPath() . 'dir2');

    $this->assertEquals(0744, $dir1->permissions());
    $this->assertEquals(0744, $dir2->permissions());
  }

  /**
   * A directory's parent must reflect its absolute path without its local.
   */
  public function testParentDirectoryPath() {
    $dir = new Directory(self::root() . 'dir');
    $this->assertEquals(\realpath(self::root()) . DIRECTORY_SEPARATOR, $dir->parentPath());
  }

  /**
   * Test that a directory instance discovers all files in its filesystem counterpart.
   */
  public function testListFiles() {
    $dir = new Directory(self::root() . 'dir');
    fopen($dir->systemPath() . 'file1', 'w');
    fopen($dir->systemPath() . 'file2', 'w');
    $this->assertEquals(2, count($dir->files()));
  }

  /**
   * Test that an existing file inside a folder can be found by its name.
   */
  public function testFindFile() {
    $dir = new Directory(self::root() . 'dir');
    $dir->put('file1');

    $this->assertInstanceOf(File::class, $dir->find('file1'));
    $this->assertFalse($dir->find('file2'));
  }

}
