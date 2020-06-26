<?php

namespace Tozart\Test\Discovery;

use Tozart\Discovery\Filter\ModelValidationFilter;

/**
 * Test class for testing model file discovery.
 *
 * @package Tozart\Test\Discovery
 */
class ModelDiscoveryTest extends DiscoveryTestCase {

  /**
   * {@inheritDoc}
   */
  protected function discoveryRoots() {
    return [$this->modelRoot()];
  }

  /**
   * {@inheritDoc}
   */
  public function filters() {
    $yaml = $this->fileSystem()->getFileType('yaml');

    $filters = [new ModelValidationFilter($yaml)];
    $expected_files = [
      $this->fileSystem()->file('page.yml', $this->modelRoot())->path(),
      $this->fileSystem()->file('sample.yml', $this->modelRoot())->path(),
    ];

    return [
      [
        $filters,
        $expected_files,
      ],
    ];
  }

}
