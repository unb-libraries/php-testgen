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

}
