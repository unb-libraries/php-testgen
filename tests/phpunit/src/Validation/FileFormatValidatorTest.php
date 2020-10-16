<?php

namespace Tozart\Test\Validation;

use Tozart\os\FileInterface;
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
    return new FileFormatValidator($this->createParser());
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
