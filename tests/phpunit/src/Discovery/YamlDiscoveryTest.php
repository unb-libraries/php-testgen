<?php

namespace Tozart\Test\Discovery;

use Tozart\Discovery\Filter\FileFormatValidationFilter;
use Tozart\Discovery\Filter\FileTypeFilter;

/**
 * Test class for testing YAML file discovery.
 *
 * @package Tozart\Test\Discovery
 */
class YamlDiscoveryTest extends DiscoveryTestCase {

  /**
   * Retrieve the path to the test directory.
   *
   * @return string
   *   A string.
   */
  protected function root() {
    /** @noinspection PhpUndefinedConstantInspection */
    return ASSET_ROOT . DIRECTORY_SEPARATOR . 'yaml';
  }

  /**
   * {@inheritDoc}
   */
  protected function discoveryRoots() {
    return [$this->root()];
  }

  /**
   * {@inheritDoc}
   */
  public function filters() {
    $yaml = $this->fileSystem()->getFileType('yaml');
    return [
      [
        [new FileTypeFilter($yaml)],
        [
          $this->fileSystem()->file('example.yml', $this->root())->path(),
          $this->fileSystem()->file('malformed.yml', $this->root())->path(),
        ],
      ], [
        [new FileFormatValidationFilter($yaml)],
        [
          $this->fileSystem()->file('example.yml', $this->root())->path(),
        ],
      ],
    ];
  }

}
