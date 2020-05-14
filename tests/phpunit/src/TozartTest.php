<?php

namespace Tozart\Test;

use PHPUnit\Framework\TestCase;
use Tozart\os\FileSystem;
use Tozart\Subject\SubjectFactory;
use Tozart\render\Printer;
use Tozart\Tozart;

class TozartTest extends TestCase {

  /**
   * Test that the application including all dependencies can be initialized.
   */
  public function testInit() {
    $this->assertInstanceOf(FileSystem::class, Tozart::fileSystem());
    $this->assertInstanceOf(SubjectFactory::class, Tozart::subjectFactory());
    $this->assertInstanceOf(Printer::class, Tozart::printer());
  }

}
