<?php

namespace Tozart\Test\Discovery\Filter;

use PHPUnit\Framework\TestCase;
use Tozart\Discovery\Filter\DirectoryFilterInterface;
use Tozart\os\FileInterface;

/**
 * Test case for directory filter tests.
 *
 * @package Tozart\Test\Discovery\Filter
 */
abstract class DirectoryFilterTestCase extends TestCase {

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
    $this->_filter = $this->createFilter();
    parent::setUp();
  }

  /**
   * Create a filter instance to test.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterInterface
   *   A directory filter object.
   */
  abstract protected function createFilter();

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
  abstract public function fileProvider();

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