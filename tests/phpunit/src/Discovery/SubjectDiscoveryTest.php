<?php

namespace Tozart\Test\Discovery;

use Tozart\Discovery\Filter\SubjectValidationFilter;

class SubjectDiscoveryTest extends DiscoveryTestCase {

  /**
   * @inheritDoc
   */
  protected function discoveryRoots() {
    return [$this->subjectRoot()];
  }

  /**
   * @inheritDoc
   */
  public function filters() {
    $yaml = $this->fileSystem()->getFileType('yaml');

    $filters = [new SubjectValidationFilter($yaml)];
    $expected_files = [
      $this->fileSystem()->file('home.page.yml', $this->subjectRoot())->path(),
    ];

    return [
      [
        $filters,
        $expected_files,
      ],
    ];
  }

}