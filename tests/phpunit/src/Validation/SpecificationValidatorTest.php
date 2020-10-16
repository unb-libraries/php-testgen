<?php

namespace Tozart\Test\Validation;

use Symfony\Component\Yaml\Yaml;
use Tozart\os\FileInterface;
use Tozart\os\parse\FileParserInterface;

/**
 * Test the SpecificationValidator class.
 *
 * @package Tozart\Test\Validation
 */
class SpecificationValidatorTest extends ValidatorTestCase {

  /**
   * {@inheritDoc}
   */
  protected function createValidator() {
    return new TestableSpecificationValidator($this->createParser());
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
        return Yaml::parse($file->content());
      });
    return $parser;
  }

  /**
   * {@inheritDoc}
   */
  public function fileProvider() {
    return [
      [$this->createFile('file_0', 'test',"requiredProperty: ''"), FALSE],
      [$this->createFile('file_1', 'test', "requiredProperty: 'someValue'"), TRUE],
      [$this->createFile('file_2', 'test', "requiredProperty: 'someValue'\noptionalProperty: 'someValue'"), TRUE],
      [$this->createFile('file_3', 'test', "requiredProperty: 'someValue'\noptionalProperty: 1"), FALSE],
    ];
  }

}
