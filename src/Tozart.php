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

  const PROJECT_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..';
  const CONFIG_DIR = self::PROJECT_ROOT . DIRECTORY_SEPARATOR . 'config';

  /**
   * The application container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $_container;

  /**
   * The only Tozart that should ever exist.
   *
   * @var \Tozart\Tozart
   */
  protected static $_instance;

  /**
   * Create (or retrieve) the only Tozart that should ever exist.
   *
   * @return \Tozart\Tozart
   *   A Tozart instance.
   */
  public static function instance() {
    if (!static::$_instance) {
      static::$_instance = new static();
    }
    return static::$_instance;
  }

  /**
   * Create a new TestGen instance.
   */
  private function __construct() {
    static::initContainer();
  }

  /**
   * Initialize the application. Load components.
   */
  protected function initContainer() {
    $container = new ContainerBuilder();
    try {
      $loader = new YamlFileLoader($container, new FileLocator(self::CONFIG_DIR));
      $loader->load('services.yml');

      $container->setParameter('tozart_root', defined('TOZART_ROOT')
        ? TOZART_ROOT
        : self::PROJECT_ROOT);
      $container->setParameter('model_root', defined('MODEL_ROOT')
        ? MODEL_ROOT
        : rtrim($container->getParameter('tozart_root')) . DIRECTORY_SEPARATOR . 'models');
      $container->setParameter('subject_root', defined('SUBJECT_ROOT')
        ? SUBJECT_ROOT
        : rtrim($container->getParameter('tozart_root')) . DIRECTORY_SEPARATOR . 'subjects');
      $container->setParameter('template_root', defined('TEMPLATE_ROOT')
        ? TEMPLATE_ROOT
        : rtrim($container->getParameter('tozart_root')) . DIRECTORY_SEPARATOR . 'templates');
    }
    catch (\Exception $e) {
      // TODO: Log error during container initialization.
      throw $e;
    }
    finally {
      $this->_container = $container;
    }
  }

  /**
   * Retrieve the application container.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerInterface
   *   A service container.
   */
  public static function container() {
    $instance = static::instance();
    if (!isset($instance->_container)) {
      $instance->initContainer();
    }
    return $instance->_container;
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
   * The model manager service.
   *
   * @return \Tozart\Model\ModelManagerInterface
   *   A model manager service instance.
   */
  public static function modelManager() {
    /** @var \Tozart\Model\ModelManagerInterface $model_manager */
    $model_manager = static::container()->get('model.manager');
    return $model_manager;
  }

  /**
   * The model factory service.
   *
   * @return \Tozart\Model\ModelFactory
   *   A model factory service instance.
   */
  public static function modelFactory() {
    /** @var \Tozart\Model\ModelFactory $model_factory */
    $model_factory = static::container()->get('model.factory');
    return $model_factory;
  }

  /**
   * The project root directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory object.
   */
  public function root() {
    $root_path = $this->container()->getParameter('TOZART_ROOT');
    return $this->fileSystem()->dir($root_path);
  }

  /**
   * The model root directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory object.
   */
  public function modelRoot() {
    $model_root_path = $this->container()->getParameter('MODEL_ROOT');
    return $this->fileSystem()->dir($model_root_path);
  }

  /**
   * The subject root directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory object.
   */
  public function subjectRoot() {
    $subject_root_path = $this->container()->getParameter('SUBJECT_ROOT');
    return $this->fileSystem()->dir($subject_root_path);
  }

  /**
   * The template root directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory object.
   */
  public function templateRoot() {
    $template_root_path = $this->container()->getParameter('TEMPLATE_ROOT');
    return $this->fileSystem()->dir($template_root_path);
  }

  /**
   * The file parser manager service.
   *
   * @return \Tozart\os\parse\FileParserManagerInterface
   *   A file parser manager service instance.
   */
  public static function fileParserManager() {
    /** @var \Tozart\os\parse\FileParserManagerInterface $file_parser_manager */
    $file_parser_manager = static::container()->get('file_system.parse.manager');
    return $file_parser_manager;
  }

  /**
   * The subject discovery service.
   *
   * @return \Tozart\Discovery\DiscoveryInterface
   *   A subject discovery service instance.
   */
  public static function subjectDiscovery() {
    /** @var \Tozart\Discovery\DiscoveryInterface $subject_discovery */
    $subject_discovery = static::container()->get('subject.discovery');
    return $subject_discovery;
  }

  /**
   * The subject manager service.
   *
   * @return \Tozart\Subject\SubjectManager
   *   A subject manager service instance.
   */
  public static function subjectManager() {
    /** @var \Tozart\Subject\SubjectManager $subject_manager */
    $subject_manager = static::container()->get('subject.manager');
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
    $factory = static::container()->get('subject.factory');
    return $factory;
  }

  /**
   * Write tests for all discoverable subjects.
   *
   * @param \Tozart\os\DirectoryInterface|string $destination
   *   The output directory or path.
   */
  public function generate($destination) {
    if (is_string($destination)) {
      $destination = $this->fileSystem()->dir($destination);
    }

    foreach ($this->subjectManager()->subjects() as $subject_id => $subject) {
      if (($context = static::contextFactory()->create($subject)) && ($content = static::renderer()->render($context))) {
        $test_case = $destination->put($context->getTemplate()->name());
        $test_case->setContent($content);
      }
    }
  }

  /**
   * The template locator service.
   *
   * @return \Tozart\Discovery\DiscoveryInterface
   *   A template locator service instance.
   */
  public static function templateDiscovery() {
    /** @var \Tozart\Discovery\DiscoveryInterface $template_discovery */
    $template_discovery = static::container()->get('render.template_discovery');
    return $template_discovery;
  }

  /**
   * The template finder service.
   *
   * @return \Tozart\render\TemplateFinderInterface
   *   A template finder service instance.
   */
  public static function templateFinder() {
    /** @var \Tozart\render\TemplateFinderInterface $template_finder */
    $template_finder = static::container()->get('render.template_finder');
    return $template_finder;
  }

  /**
   * The context factory service.
   *
   * @return \Tozart\render\RenderContextFactoryInterface
   *   A render context factory service instance.
   */
  public static function contextFactory() {
    /** @var \Tozart\render\RenderContextFactoryInterface $context_factory */
    $context_factory = static::container()->get('render.context_factory');
    return $context_factory;
  }

  /**
   * The printer service.
   *
   * @return \Tozart\render\RendererInterface
   *   A renderer service instance.
   */
  public static function renderer() {
    /** @var \Tozart\render\RendererInterface $renderer */
    $renderer = static::container()->get('render.renderer');
    return $renderer;
  }

  /**
   * The validator factory service.
   *
   * @return \Tozart\Validation\ValidatorFactoryInterface
   *   A validator factory instance.
   */
  public static function validatorFactory() {
    /** @var \Tozart\Validation\ValidatorFactoryInterface $factory */
    $factory = static::container()->get('validator.factory');
    return $factory;
  }

  /**
   * The filter factory service.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A filter factory instance.
   */
  public static function directoryFilterFactory() {
    /** @var \Tozart\Discovery\Filter\DirectoryFilterFactoryInterface $factory */
    $factory = static::container()->get('directory_filter.factory');
    return $factory;
  }

}
