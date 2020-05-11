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
   * The file system service.
   *
   * @return \Tozart\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem() {
    /** @var \Tozart\os\FileSystem $file_system */
    $file_system = static::container()->get('file_system');
    return $file_system;
  }

  /**
   * The subject manager service.
   *
   * @return \Tozart\Subject\SubjectManager
   *   A subject manager service instance.
   */
  public static function subjectManager() {
    /** @var \Tozart\Subject\SubjectManager $subject_manager */
    $subject_manager = static::container()->get('subject_manager');
    return $subject_manager;
  }

  /**
   * The subject factory service.
   *
   * @return \Tozart\Subject\SubjectFactory
   *   A subject factory service instance.
   */
  public static function subjectFactory() {
    /** @var \Tozart\Subject\SubjectFactory $factory */
    $factory = static::container()->get('subject_factory');
    return $factory;
  }

  /**
   * Write tests for all available subjects.
   *
   * @param mixed $dir
   *   The output directory or path.
   */
  public function write($dir) {
    if (is_string($dir)) {
      $dir = $this->fileSystem()->dir($dir);
    }
    $this->templateLocator()->setFileExtension(
      $this->printer()->templateFileExtension());
    foreach ($this->subjectManager()->subjects() as $subject_id => $subject) {
      $template = $this->templateLocator()->getTemplate($subject);
      $test_case = $dir->put($template->name());
      $content = $this->printer()
        ->render($template, $subject->getProperties());
      $test_case->setContent($content);
    }
  }

  /**
   * The template locator service.
   *
   * @return \Tozart\render\TemplateLocator
   *   A template locator service instance.
   */
  public static function templateLocator() {
    /** @var \Tozart\render\TemplateLocator $template_locator */
    $template_locator = static::container()->get('template_locator');
    return $template_locator;
  }

  /**
   * The printer service.
   *
   * @return \Tozart\render\Printer
   *   A printer service instance.
   */
  public static function printer() {
    /** @var \Tozart\render\Printer $printer */
    $printer = static::container()->get('printer');
    return $printer;
  }

}
