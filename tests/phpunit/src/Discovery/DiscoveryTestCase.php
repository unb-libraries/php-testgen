<?php

namespace Tozart\Test\Discovery;

use Tozart\Discovery\DiscoveryBase;
use Tozart\os\FileInterface;
use Tozart\Test\TozartTestCase;

/**
 * Test case for testing file discovery.
 *
 * This test case should be extended to test new filter.
 *
 * @package Tozart\Test\Discovery
 */
abstract class DiscoveryTestCase extends TozartTestCase {

  /**
   * The discovery instance to test.
   *
   * @var DiscoveryBase
   */
  protected $discovery;

  /**
   * Retrieve the discovery instance to test.
   *
   * @return DiscoveryBase
   *   A discovery object.
   */
  public function discovery() {
    return $this->discovery;
  }

  /**
   * Set the discovery object to test.
   *
   * @param \Tozart\Discovery\DiscoveryBase $discovery
   *   A discovery object.
   */
  protected function setDiscovery(DiscoveryBase $discovery) {
    $this->discovery = $discovery;
  }

  /**
   * Retrieve the directories on which to test the discovery implementation.
   *
   * @return \Tozart\os\DirectoryInterface[]
   *   Array of directories.
   */
  abstract protected function discoveryRoots();

  /**
   * Initialize a fresh Discovery instance before each test.
   */
  protected function setUp(): void {
    parent::setUp();
    $discovery = new Discovery($this->discoveryRoots());
    $this->setDiscovery($discovery);
  }

  /**
   * Test that each set of filters leads to the expected set of discovered files.
   *
   * @param array $filters
   *   An array of filters.
   * @param \Tozart\os\FileInterface[] $files
   *   An array of filenames which the discovery
   *   is expected to find after applying given filters.
   *
   * @dataProvider filterProvider
   */
  public function testFind(array $filters, array $files) {
    foreach ($filters as $filter) {
      $this->discovery()->addFilter($filter);
    }

    // If no filters provided, expect to discover every file in every source folder.
    if (empty($filters)) {
      $files = [];
      foreach ($this->discovery()->directoryStack() as $source_dir) {
        $files = array_merge($files, array_map(function (FileInterface $file) {
          return $file->path();
        }, $source_dir->files()));
      }
    }

    $discoveries = array_keys($this->discovery()->discover());
    $this->assertEquals(sort($files, SORT_STRING), sort($discoveries, SORT_STRING));
  }

  /**
   * Set of filter scenarios.
   *
   * @return array
   *   An array or arrays, each of which must contain the
   *   following two entries:
   *   - filters: (array) Collection of filter instances.
   *   - expected_files: (array) Collection of files that
   *   are expected to be discovered after applying the
   *   given filter(s).
   *
   * @see \Tozart\Discovery\Filter\DirectoryFilterInterface
   * @see \Tozart\os\FileInterface
   */
  abstract public function filters();

  /**
   * Data provider for testFind().
   *
   * @return array
   *   An array of arrays, each of which contains the following
   *   two entries:
   *   - a filter instance
   *   - an array of file instances, which the filter is
   *   expected to discover.
   */
  public final function filterProvider() {
    return $this->powerSet($this->filters());
  }

  /**
   * Create a power set of the given filter scenario collection.
   *
   * @param array $filter_scenarios
   *   An array of filter scenarios.
   *
   * @return array
   *   An array of filter scenarios.
   */
  private function powerSet(array $filter_scenarios) {
    $power_set = [[[],[]]];
    foreach ($filter_scenarios as $scenario) {
      foreach ($power_set as $sub_set) {
        $power_set[] = $this->mergeScenarios($scenario, $sub_set);
      }
    }
    return $power_set;
  }

  /**
   * Merge the given scenarios.
   *
   * @param array $scenario
   *   A filter scenario.
   * @param array $other_scenario
   *   Another filter scenario.
   *
   * @return array
   *   A filter scenario that contains the
   *   sum of filters and shared set
   *   of commonly expected files of both
   *   input scenarios.
   */
  private function mergeScenarios($scenario, $other_scenario) {
    [$filters, $expected_files] = $scenario;
    [$other_filters, $other_expected_files] = $other_scenario;
    $filters = array_merge($filters, $other_filters);
    if (!empty($other_expected_files)) {
      $expected_files = array_intersect($expected_files, $other_expected_files);
    }
    return [$filters, $expected_files];
  }

}
