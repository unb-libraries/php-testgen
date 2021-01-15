<?php

namespace Trupal\Test\Discovery\Filter;

use Trupal\Discovery\Filter\FileTypeFilter;
use Trupal\os\FileTypeInterface;

/**
 * Test the FileTypeFilterTest class.
 *
 * @package Trupal\Test\Discovery\Filter
 */
class FileTypeFilterTest extends DirectoryFilterTestCase {

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
   * {@inheritDoc}
   */
  protected function createFilter() {
    return new FileTypeFilter($this->createFileType([$this->getExtension()]));
  }

  /**
   * Create a file type double.
   *
   * @param array $extensions
   *   Array of file extensions to be associated with the file type.
   *
   * @return \Trupal\os\FileTypeInterface
   *   An object pretending to be a file type.
   */
  protected function createFileType(array $extensions) {
    $file_type = $this->createStub(FileTypeInterface::class);
    $file_type->method('getExtensions')
      ->willReturn($extensions);
    return $file_type;
  }

  /**
   * {@inheritDoc}
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

}
