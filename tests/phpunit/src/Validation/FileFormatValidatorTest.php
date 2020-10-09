<?php

namespace Tozart\Test\Validation;

use Tozart\os\FileInterface;
use Tozart\os\FileTypeInterface;
use Tozart\os\parse\FileParserInterface;
use Tozart\Validation\FileFormatValidator;

/**
 * Test the FileFormatValidator class.
 *
 * @package Tozart\Test\Validation
 */
class FileFormatValidatorTest extends ValidatorTestCase {

  /**
   * {@inheritDoc}
   */
  protected function createValidator() {
    return new FileFormatValidator($this->createFileType());
  }

  /**
   * Create a file type test double.
   *
   * @return \Tozart\os\FileTypeInterface
   *   An object pretending to be a file type.
   */
  protected function createFileType() {
    $file_type = $this->createStub(FileTypeInterface::class);

    if (!empty($this->getProvidedData())) {
      $current_file = $this->getProvidedData()[0];
      $parser = $this->createParser();

      $file_type->method('getParser')
        ->willReturnCallback(function () use ($current_file, $parser) {
          return $current_file->extension() === 'test' ? $parser : NULL;
        });
    }

    return $file_type;
  }

  /**
   * Create a parser test double.
   *
   * @return \Tozart\os\parse\FileParserInterface
   *   An object pretending to be a file parser.
   */
  protected function createParser() {
    $parser = $this->createStub(FileParserInterface::class);
    $parser->method('parse')
      ->willReturnCallback(function (FileInterface $file) {
        if (preg_match('/(\w+\.)+/', $content = $file->content())) {
          return explode('.', $content);
        }
        return NULL;
      });
    return $parser;
  }

  /**
   * {@inheritDoc}
   */
  public function fileProvider() {
    return [
      [$this->createFile('file_0', 'test', 'This is a test. It is very simple.'), TRUE],
      [$this->createFile('file_1', 'test', 'This sentence includes no period'), FALSE],
      [$this->createFile('file_2'), FALSE],
    ];
  }

}
