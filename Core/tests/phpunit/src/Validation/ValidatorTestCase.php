<?php

namespace Trupal\Core\Test\Validation;

use PHPUnit\Framework\TestCase;
use Trupal\Core\os\FileInterface;
use Trupal\Core\Validation\ValidatorInterface;

/**
 * Test case for validator tests.
 *
 * @package Trupal\Core\Test\Validation
 */
abstract class ValidatorTestCase extends TestCase {

  /**
   * The validator to test.
   *
   * @var \Trupal\Core\Validation\ValidatorInterface
   */
  protected $_validator;

  /**
   * Retrieve the validator to test.
   *
   * @return \Trupal\Core\Validation\ValidatorInterface
   *   A validator object.
   */
  protected function validator() {
    return $this->_validator;
  }

  /**
   * Set up a validator instance to test.
   */
  protected function setUp(): void {
    $this->_validator = $this->createValidator();
    parent::setUp();
  }

  /**
   * Create a validator instance to test.
   *
   * @return \Trupal\Core\Validation\ValidatorInterface
   *   A validator object.
   */
  abstract protected function createValidator();

  /**
   * Test that the validator implements the ValidatorInterface.
   */
  public function testImplementsInterface() {
    $this->assertInstanceOf(ValidatorInterface::class, $this->validator());
  }

  /**
   * Test the "validate" method.
   *
   * @param \Trupal\Core\os\FileInterface $file
   *   A file.
   * @param bool $should_pass
   *   Whether the file is expected to pass.
   *
   * @dataProvider fileProvider
   */
  public function testValidate(FileInterface $file, bool $should_pass) {
    $this->assertEquals($should_pass, $this->validator()->validate($file));
  }

  /**
   * Provide file instances for testValidate.
   *
   * @return array[]
   *   An array of arrays, each containing a file and whether
   *   it's expected to pass the validator.
   */
  abstract public function fileProvider();

  /**
   * Create a file double.
   *
   * @param string $name
   *   The name of the file.
   * @param string $extension
   *   (optional) The file type extension of the file.
   *   Leave blank for no extension.
   * @param string $content
   *   (optional) The content to put in the file.
   *
   * @return \PHPUnit\Framework\MockObject\Stub
   *   An object pretending to be a file.
   */
  protected function createFile(string $name, string $extension = '', $content = '') {
    if (!empty($extension)) {
      $name = "{$name}.{$extension}";
    }
    $file = $this->createStub(FileInterface::class);
    $file->method('name')
      ->willReturn($name);
    $file->method('extension')
      ->willReturn($extension);
    $file->method('content')
      ->willReturn($content);
    return $file;
  }

  /**
   * Test that specification contains valid configuration (default) values.
   */
  public function testSpecification() {
    $this->markTestIncomplete();
  }

}
