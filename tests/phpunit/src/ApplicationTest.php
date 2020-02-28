<?php

namespace TestGen\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TestGen\generate\TestGenerator;
use TestGen\model\ModelFactory;
use TestGen\render\RenderEngine;
use TestGen\TestGen;

class ApplicationTest extends TestCase {

  /**
   * Test that the application including all dependencies can be initialized.
   */
  public function testInit() {
    $app = new TestGen();
    $this->assertInstanceOf(ContainerInterface::class, $app->container());
    $this->assertInstanceOf(TestGenerator::class, $app->generator());
    $this->assertInstanceOf(ModelFactory::class, TestGen::modelBuilder());
    $this->assertInstanceOf(RenderEngine::class, TestGen::renderer());
  }

}