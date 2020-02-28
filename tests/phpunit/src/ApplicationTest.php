<?php

namespace TestGen\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TestGen\TestGen;

class ApplicationTest extends TestCase {

  /**
   * Test that the application including all dependencies can be initialized.
   */
  public function testInit() {
    $app = new TestGen();
    $this->assertInstanceOf(ContainerInterface::class, $app->container());
  }

}