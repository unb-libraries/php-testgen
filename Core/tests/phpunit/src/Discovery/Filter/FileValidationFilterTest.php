<?php

namespace Trupal\Core\Test\Discovery\Filter;

use Trupal\Core\Discovery\Filter\FileValidationFilter;
use Trupal\Core\os\FileInterface;
use Trupal\Core\Validation\ValidatorInterface;

/**
 * Test the FileValidationFilter class.
 *
 * @package Trupal\Core\Test\Discovery\Filter
 */
class FileValidationFilterTest extends DirectoryFilterTestCase {

  /**
   * {@inheritDoc}
   */
  protected function createFilter() {
    return new FileValidationFilter($this->createValidator());
  }

  /**
   * Create a validator double.
   *
   * @return \Trupal\Core\Validation\ValidatorInterface
   *   An object pretending to be a validator.
   */
  protected function createValidator() {
    $validator = $this->createStub(ValidatorInterface::class);
    $validator->method('validate')
      ->willReturnCallback(function (FileInterface $file) {
        return $file->extension() === 'test';
      });
    return $validator;
  }

  /**
   * {@inheritDoc}
   */
  public function fileProvider() {
    return [
      [$this->createFile('file_0', 'test'), TRUE],
      [$this->createFile('file_1'), FALSE],
    ];
  }

}
