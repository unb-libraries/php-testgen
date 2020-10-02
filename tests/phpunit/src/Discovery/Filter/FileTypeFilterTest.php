<?php

namespace Tozart\Test\Discovery\Filter;

use PHPUnit\Framework\TestCase;
use Tozart\Discovery\Filter\FileTypeFilter;
use Tozart\os\FileInterface;
use Tozart\os\FileTypeInterface;

/**
 * Test the FileTypeFilterTest class.
 *
 * @package Tozart\Test\Discovery\Filter
 */
class FileTypeFilterTest extends TestCase {

  /**
   * The filter to test.
   *
   * @var \Tozart\Discovery\Filter\FileTypeFilter
   */
  protected $_filter;

  /**
   * Retrieve the filter to test.
   *
   * @return \Tozart\Discovery\Filter\FileTypeFilter
   */
  protected function filter() {
    return $this->_filter;
  }

  /**
   * Set up a filter instance to test.
   */
  protected function setUp(): void {
    $this->_filter = new FileTypeFilter($this->createFileType([$this->getExtension()]));
    parent::setUp();
  }

  /**
   * Retrieve file type extension.
   *
   * @return string
   *   A string.
   */
  protected function getExtension() {
    return 'test';
  }

  /**
   * Create a file type double.
   *
   * @param array $extensions
   *   Array of file extensions to be associated with the file type.
   *
   * @return \Tozart\os\FileTypeInterface
   *   An object pretending to be a file type.
   */
  protected function createFileType(array $extensions) {
    $file_type = $this->createStub(FileTypeInterface::class);
    $file_type->method('getExtensions')
      ->willReturn($extensions);
    return $file_type;
  }

  /**
   * Test the "evaluate" method.
   *
   * @param \Tozart\os\FileInterface $file
   *   A file.
   * @param bool $should_pass
   *   Whether the file is expected to pass.
   *
   * @dataProvider fileProvider
   */
  public function testEvaluate(FileInterface $file, bool $should_pass) {
    $this->assertEquals($should_pass, $this->filter()->evaluate($file));
  }

  /**
   * Provide file instances for testEvaluate.
   *
   * @return array[]
   *   An array of arrays, each containing a file and whether
   *   it's expected to pass the filter.
   */
  public function fileProvider() {
    $extension = $this->getExtension();
    return [
      [$this->createFile('file_0', $extension), TRUE],
      [$this->createFile('file_1', $extension . $extension), FALSE],
      [$this->createFile("file_2.{$extension}{$extension}", $extension), TRUE],
      [$this->createFile("file_3.{$extension}", $extension . $extension), FALSE],
      [$this->createFile('', $extension), TRUE],
      [$this->createFile('file_5', ''), FALSE],
    ];
  }

  /**
   * Create a file double.
   *
   * @param string $name
   *   The name of the file.
   * @param string $extension
   *   The file type extension of the file.
   *
   * @return \PHPUnit\Framework\MockObject\Stub
   *   An object pretending to be a file.
   */
  protected function createFile(string $name, string $extension) {
    if (!empty($extension)) {
      $name = "{$name}.{$extension}";
    }
    $file = $this->createStub(FileInterface::class);
    $file->method('name')
      ->willReturn($name);
    $file->method('extension')
      ->willReturn($extension);
    return $file;
  }

}
