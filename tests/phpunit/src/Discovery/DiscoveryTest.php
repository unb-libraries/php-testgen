<?php

namespace Tozart\Test\Discovery;

use PHPUnit\Framework\TestCase;
use Tozart\Discovery\Filter\DirectoryFilterInterface;
use Tozart\os\DirectoryInterface;
use Tozart\os\FileInterface;

/**
 * Test the DiscoveryBase class.
 *
 * @package Tozart\Test\Discovery
 */
class DiscoveryTest extends TestCase {

  /**
   * The discovery.
   *
   * @var \Tozart\Test\Discovery\Discovery
   */
  protected $_discovery;

  /**
   * Retrieve the discovery.
   *
   * @return \Tozart\Test\Discovery\Discovery
   *   A discovery object.
   */
  protected function discovery() {
    return $this->_discovery;
  }

  /**
   * Set up a discovery with directories.
   */
  protected function setUp(): void {
    $this->_discovery = new Discovery([
      $this->createDirectory('/dir2/', $this->createFiles(1, '/dir2/')),
      $this->createDirectory('/dir1/', $this->createFiles(3, '/dir1/')),
    ]);
    parent::setUp();
  }

  /**
   * Create a directory double.
   *
   * @param string $path
   *   The path under which the directory should appear.
   * @param array $files
   *   An array of files which the directory contains.
   *
   * @return \PHPUnit\Framework\MockObject\Stub
   *   An object pretending to be a directory.
   */
  protected function createDirectory(string $path, array $files) {
    $dir = $this->createStub(DirectoryInterface::class);
    $dir->method('systemPath')
      ->willReturn($path);
    $dir->method('files')
      ->willReturn($files);
    return $dir;
  }

  /**
   * Create a number of file doubles.
   *
   * @param int $count
   *   The number of files doubles to create.
   * @param string $dir
   *   The directory path under which files should appear.
   *
   * @return array
   *   An array of objects pretending to be files.
   */
  protected function createFiles(int $count, string $dir) {
    $files = [];
    foreach (range(1, $count) as $index) {
      $files[] = $this->createFile("file_{$index}.test", $dir);
    }
    return $files;
  }

  /**
   * Create a file double.
   *
   * @param string $name
   *   The name of the file.
   * @param string $path
   *   The directory path under which the file should appear.
   *
   * @return \PHPUnit\Framework\MockObject\Stub
   *   An object pretending to be a file.
   */
  protected function createFile($name, $path) {
    $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $file = $this->createStub(FileInterface::class);
    $file->method('name')
      ->willReturn($name);
    $file->method('path')
      ->willReturn($path . $name);
    return $file;
  }

  /**
   * Test the "discover" method.
   *
   * Discover is expected to return an array of files which
   * - are in one of the directories which the discovery observes
   * - pass ALL filters that are applied to the discovery.
   *
   * Discovered files are expected to be sorted according to their
   * directories position in the discovery's directory stack, i.e. files
   * that are discovered in the directory at the top of the stack appear
   * before any other directory's files.
   *
   * @param array $filters
   *   Array of directory filters.
   * @param array $expected_file_paths
   *   Array indicating under which paths
   *   to expect discovering files.
   *
   * @dataProvider getDiscoveryScenarios
   */
  public function testDiscover(array $filters, array $expected_file_paths) {
    $discovery = $this->discovery();
    foreach ($filters as $filter) {
      $discovery->addFilter($filter);
    }

    $actually_discovered_file_paths = array_map(function (FileInterface $file) {
      return $file->path();
    }, $discovery->discover());

    $this->assertEquals(array_values($expected_file_paths), array_values($actually_discovered_file_paths));
  }

  /**
   * Provide scenarios to feed into testDiscover.
   *
   * @return array
   *   An array containing
   *   - filters: (array) an array of filters to apply before discovery.
   *   - expected_file_paths: (array) an array of file paths under which
   *   to expect those files that pass all filters.
   */
  public function getDiscoveryScenarios() {
    return [
      'no_filter' => [
        'filters' => [],
        'expected_file_paths' => [
          '/dir2/file_1.test',
          '/dir1/file_1.test',
          '/dir1/file_2.test',
          '/dir1/file_3.test',
        ],
      ],
      'intersecting_filters' => [
        'filters' => [
          $this->createFilter([
            'dir2' => [
              'file_1.test' => TRUE,
            ],
            'dir1' => [
              'file_1.test' => FALSE,
              'file_2.test' => FALSE,
              'file_3.test' => TRUE,
            ]]),
          $this->createFilter([
            'dir2' => [
              'file_1.test' => TRUE,
            ],
            'dir1' => [
              'file_1.test' => TRUE,
              'file_2.test' => FALSE,
              'file_3.test' => TRUE,
            ]]),
        ],
        'expected_file_paths' => [
          '/dir2/file_1.test',
          '/dir1/file_3.test',
        ],
      ],
    ];
  }

  /**
   * Create a filter double.
   *
   * @param array $return_sequences
   *   A (nested) array indicating consecutive
   *   results of filter evaluations.
   *
   * @return \PHPUnit\Framework\MockObject\Stub
   *   An object pretending to be a directory filter.
   */
  protected function createFilter(array $return_sequences) {
    $flat_return_sequence = [];
    foreach (array_values($return_sequences) as $return_sequence) {
      $flat_return_sequence = array_merge($flat_return_sequence, array_values($return_sequence));
    }

    $filter = $this->createStub(DirectoryFilterInterface::class);
    $filter->method('evaluate')
      ->willReturnOnConsecutiveCalls(...$flat_return_sequence);

    return $filter;
  }

  /**
   * Test the findBy method.
   */
  public function testFindBy() {
    // TODO: Remove testFindBy once the method has been removed.
    $this->markTestIncomplete();
  }

}