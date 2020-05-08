<?php

namespace Tozart;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Where it all begins.
 *
 * @package Tozart
 */
final class Tozart {

  const TOZART_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..';
  const CONFIG_DIR = self::TOZART_ROOT . DIRECTORY_SEPARATOR . 'config';

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

      $container->setParameter('TOZART_ROOT', self::TOZART_ROOT);
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
   * @return \Tozart\Director
   *   The generator service.
   */
  public static function director() {
    /** @var \Tozart\Director $director */
    $director = static::container()->get('director');
    return $director;
  }

  /**
   * The model builder.
   *
   * @return \Tozart\Subject\SubjectFactory
   *   A model factory service instance.
   */
  public static function subjectFactory() {
    /** @var \Tozart\Subject\SubjectFactory $factory */
    $factory = static::container()->get('subject_factory');
    return $factory;
  }

  /**
   * The render engine.
   *
   * @return \Tozart\render\Printer
   *   The render engine.
   */
  public static function printer() {
    /** @var \Tozart\render\Printer $printer */
    $printer = static::container()->get('printer');
    return $printer;
  }

}
