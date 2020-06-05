<?php

namespace Tozart\Test\Discovery;

use Tozart\Discovery\DiscoveryBase;
use Tozart\Discovery\Filter\FileFormatValidationFilter;
use Tozart\Discovery\Filter\FileTypeFilter;
use Tozart\Test\TozartTestCase;

/**
 * Test class for testing file discovery with default directory filter implementations.
 *
 * This class should be extended to test new filter implementations.
 *
 * @package Tozart\Test\Discovery
 */
class DiscoveryTest extends TozartTestCase {

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
   * Initialize a fresh Discovery instance before each test.
   */
  protected function setUp(): void {
    parent::setUp();
    $this->setDiscovery(new Discovery([$this->modelRoot()]));
  }

  /**
   * Test that each set of filters leads to the expected set of discovered files.
   *
   * @param array $filters
   *   An array of filters.
   * @param \Tozart\os\File[] $files
   *   An array of filenames which the discovery
   *   is expected to find after applying given filters.
   *
   * @dataProvider filterProvider
   */
  public function testFind(array $filters, array $files) {
    foreach ($filters as $filter) {
      $this->discovery()->stackFilter($filter);
    }

    // If no filters provided, expect to discover every file in every source folder.
    if (empty($filters)) {
      $files = [];
      foreach ($this->discovery()->sourceStack() as $source_dir) {
        $files = array_merge($files, $source_dir->files());
      }
    }

    $index = 0;
    $finds = $this->discovery()->find();
    foreach ($finds as $dir_path => $filenames) {
      foreach (array_keys($filenames) as $filename) {
        $file_path = $dir_path . $filename;
        // TODO: Also assert discovery "score".
        $this->assertContains($file_path, $files);
        $index++;
      }
    }
    $this->assertCount($index, $files);
  }

  /**
   * Set of default filter scenarios.
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
   * @see \Tozart\os\File
   */
  public final function defaultFilters() {
    return [
      [
        [new FileTypeFilter(['yml'])],
        [
          $this->fileSystem()->file('example.yml', $this->modelRoot())->path(),
          $this->fileSystem()->file('sample.yml', $this->modelRoot())->path(),
          $this->fileSystem()->file('malformed.yml', $this->modelRoot())->path(),
        ],
      ], [
        [new FileFormatValidationFilter('yml')],
        [
          $this->fileSystem()->file('example.yml', $this->modelRoot())->path(),
          $this->fileSystem()->file('sample.yml', $this->modelRoot())->path(),
        ],
      ],
    ];
  }

  /**
   * Additional filter scenarios.
   *
   * Subclasses should override this method to test
   * new filter implementations.
   *
   * @return array
   *   An array of arrays. See defaultFilters() method
   *   for details on the expected return format.
   *
   * @see \Tozart\Test\Discovery\DiscoveryTest::defaultFilters()
   */
  public function filters() {
    return [];
  }

  /**
   * Data provider for the testFind().
   *
   * Subclasses should override expand this method
   *
   * @return array
   *   An array of arrays. Each entry must contain
   *   the following keys:
   *   - filters:
   */
  public final function filterProvider() {
    $filters = array_merge($this->defaultFilters(), $this->filters());
    return $this->powerSet($filters);
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
