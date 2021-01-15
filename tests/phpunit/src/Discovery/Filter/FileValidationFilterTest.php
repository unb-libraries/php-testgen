<?php

namespace Trupal\Test\Discovery\Filter;

use Trupal\Discovery\Filter\FileValidationFilter;
use Trupal\os\FileInterface;
use Trupal\Validation\ValidatorInterface;

/**
 * Test the FileValidationFilter class.
 *
 * @package Trupal\Test\Discovery\Filter
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
   * @return \Trupal\Validation\ValidatorInterface
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
