<?php

namespace TestGen;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Where it all begins.
 *
 * @package TestGen
 */
final class TestGen {

  const TESTGEN_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..';
  const CONFIG_DIR = self::TESTGEN_ROOT . DIRECTORY_SEPARATOR . 'config';

  /**
   * The application container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected static $container;

  /**
   * Create a new TestGen instance.
   */
  public function __construct() {
    static::init();
  }

  /**
   * Initialize the application. Load components.
   */
  public static function init() {
    $container = new ContainerBuilder();
    try {
      $loader = new YamlFileLoader($container, new FileLocator(self::CONFIG_DIR));
      $loader->load('services.yml');

      $container->setParameter('TESTGEN_ROOT', self::TESTGEN_ROOT);
    }
    catch (\Exception $e) {
    }
    finally {
      static::$container = $container;
    }
  }

  /**
   * Retrieve the application container.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerInterface
   *   A service container.
   */
  public static function container() {
    if (!isset(static::$container)) {
      static::init();
    }
    return static::$container;
  }

  /**
   * The test generator.
   *
   * @return \TestGen\generate\TestGenerator
   *   The generator service.
   */
  public static function generator() {
    /** @var \TestGen\generate\TestGenerator $generator */
    $generator = static::container()->get('testgen.generator');
    return $generator;
  }

  /**
   * The model builder.
   *
   * @return \TestGen\model\ModelFactory
   *   A model factory service instance.
   */
  public static function modelBuilder() {
    /** @var \TestGen\model\ModelFactory $builder */
    $builder = static::container()->get('model_builder');
    return $builder;
  }

  /**
   * The render engine.
   *
   * @return \TestGen\render\RenderEngine
   *   The render engine.
   */
  public static function renderer() {
    /** @var \TestGen\render\RenderEngine $renderer */
    $renderer = static::container()->get('render_engine');
    return $renderer;
  }

}
