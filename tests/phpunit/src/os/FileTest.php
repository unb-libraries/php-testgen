<?php

namespace Tozart\Test\os;

use Tozart\os\Directory;
use Tozart\os\File;
use Tozart\os\FileType;

/**
 * Test creating and interacting with instances of the File class.
 *
 * @package Tozart\Test
 */
class FileTest extends FileSystemTestCase {

  /**
   * Test directory.
   *
   * @var \Tozart\os\DirectoryInterface
   */
  protected $directory;

  /**
   * Retrieve the test directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory instance.
   */
  protected function directory() {
    if (!isset($this->directory)) {
      $this->directory = $this
        ->fileSystem()
        ->dir(self::root());
    }
    return $this->directory;
  }

  /**
   * Any file must be associated with a type that reflects its extension.
   */
  public function testFileType() {
    $this->fileSystem()->addFileType(new FileType('txt', ['txt']));
    $file = $this->fileSystem()->file('test.txt', $this->directory());
    $this->assertEquals('txt', $file->type()->getName());
    $this->assertContains('txt', $file->type()->getExtensions());
  }

  /*/**
   * Any file instance must reflect an existing filesystem file that is readable and writable.
   */
  public function testFileIsReadableAndWritable() {
    $file = new File('test.txt', $this->directory());
    $this->assertFileIsReadable($file->path());
    $this->assertFileIsWritable($file->path());
  }

  /**
   * A new file instance must not corrupt an existing file's content.
   */
  public function testFileIsIntact() {
    $path = $this->directory()->systemPath() . 'test.txt';
    $handle = \fopen($path, 'x');
    $initial_content = 'test';
    \file_put_contents($path, $initial_content);

    $file = new File('test.txt', $this->directory());
    $content = \file_get_contents($file->path());
    \fclose($handle);

    $this->assertEquals($content, 'test');
  }

  /**
   * Files must take on explicit permissions or inherit their directory's permissions.
   */
  public function testPermissions() {
    $file = new File('file', $this->directory());
    $this->assertEquals($this->directory()->permissions(), $file->permissions());
  }

  /**
   * A copied file's content must reflect its original.
   */
  public function testCopy() {
    // TODO: Replace directory by directory interface stub.
    $source_dir = new Directory($this->directory()->systemPath() . 'source');
    $destination_dir = new Directory($this->directory()->systemPath() . 'destination');

    // Source folder files.
    // TODO: Reduce mentions of the 'File' class.
    $source1 = new File('source1', $source_dir);
    $source1_content = 'Content of the 1st source file.';
    $source1->setContent($source1_content);
    $source2 = new File('source2', $source_dir);
    $source2_content = 'Content of the 2nd source file.';
    $source2->setContent($source2_content);

    // Destination folder files.
    $destination1 = new File('destination1', $destination_dir);
    $destination1_content = 'Content of the 1st destination file.';
    $destination1->setContent($destination1_content);
    $destination2 = new File('destination2', $destination_dir);
    $destination2_content = 'Content of the 2nd destination file.';
    $destination2->setContent($destination2_content);

    $copy1 = $source1->copy($destination_dir, 'source1_copy');
    $copy2 = $source2->copy($destination_dir);
    $copy3 = $source1->copy($destination_dir, 'destination1');
    $copy4 = $source2->copy($destination_dir, 'destination2', FALSE);

    $this->assertFileExists($destination_dir->systemPath() . 'source1_copy');
    $this->assertEquals($source1_content, $copy1->content());
    $this->assertFileExists($destination_dir->systemPath() . 'source2');
    $this->assertEquals($source2_content, $copy2->content());
    $this->assertFileExists($destination_dir->systemPath() . 'destination1');
    $this->assertEquals($source1_content, $copy3->content());
    $this->assertEquals($source1_content, $destination1->content());
    $this->assertFileExists($destination_dir->systemPath() . 'destination2');
    $this->assertEquals($destination2_content, $destination2->content());
    $this->assertNull($copy4);
  }

}
