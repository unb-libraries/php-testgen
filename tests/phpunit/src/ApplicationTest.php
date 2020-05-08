<?php

namespace Tozart\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tozart\Director;
use Tozart\Subject\SubjectFactory;
use Tozart\render\Printer;
use Tozart\Tozart;

class ApplicationTest extends TestCase {

  /**
   * Test that the application including all dependencies can be initialized.
   */
  public function testInit() {
    $app = new Tozart();
    $this->assertInstanceOf(ContainerInterface::class, $app->container());
    $this->assertInstanceOf(Director::class, $app->director());
    $this->assertInstanceOf(SubjectFactory::class, Tozart::subjectFactory());
    $this->assertInstanceOf(Printer::class, Tozart::printer());
  }

}