<?php

namespace Trupal\Core\Test\Discovery\Filter;

use Trupal\Core\Discovery\Filter\FileNamePatternFilter;

/**
 * Test the FileNamePatternFilter class.
 *
 * @package Trupal\Core\Test\Discovery\Filter
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
