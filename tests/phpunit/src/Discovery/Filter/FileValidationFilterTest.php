<?php

namespace Tozart\Test\Discovery\Filter;

use Tozart\Discovery\Filter\FileValidationFilter;
use Tozart\os\FileInterface;
use Tozart\Validation\ValidatorInterface;

/**
 * Test the FileValidationFilter class.
 *
 * @package Tozart\Test\Discovery\Filter
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
   * @return \Tozart\Validation\ValidatorInterface
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
