<?php

namespace Tozart\Test\Discovery\Filter;

use Tozart\Discovery\Filter\FileNamePatternFilter;

/**
 * Test the FileNamePatternFilter class.
 *
 * @package Tozart\Test\Discovery\Filter
 */
class FileNamePatternFilterTest extends DirectoryFilterTestCase {

  /**
   * {@inheritDoc}
   */
  protected function createFilter() {
    return new FileNamePatternFilter('/^file_[0-9]+$/');
  }

  /**
   * {@inheritDoc}
   */
  public function fileProvider() {
    return [
      [$this->createFile('file_0'), TRUE],
      [$this->createFile('file_1', 'test'), FALSE],
      [$this->createFile('file_22'), TRUE],
      [$this->createFile('ffile_3'), FALSE],
      [$this->createFile('file4'), FALSE],
      [$this->createFile(''), FALSE],
    ];
  }

}
