<?php

namespace Trupal\Core;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Where it all begins.
 *
 * @package Trupal
 */
final class Trupal implements TrupalInterface {

  const PROJECT_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
  const EXT_ROOT = self::PROJECT_ROOT . DIRECTORY_SEPARATOR . 'extend';

  /**
   * The application container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerBuilder
   */
  protected $_container;

  /**
   * The only Trupal that should ever exist.
   *
   * @var \Trupal\Core\Trupal
   */
  protected static $_instance;

  /**
   * Create (or retrieve) the only Trupal that should ever exist.
   *
   * @return \Trupal\Core\Trupal
   *   A Trupal instance.
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
    try {
      $this->_container = $this->initContainer();
    }
    catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  /**
   * Initialize the application. Load components.
   */
  protected function initContainer() {
    $container = new ContainerBuilder();
    try {
      $loader = new YamlFileLoader($container, new FileLocator(self::PROJECT_ROOT));
      $loader->load('Core/config/services.yml');

      $container->setParameter('Trupal_root', defined('Trupal_ROOT')
        ? Trupal_ROOT
        : self::PROJECT_ROOT);
      $container->setParameter('model_root', defined('MODEL_ROOT')
        ? MODEL_ROOT
        : rtrim($container->getParameter('Trupal_root')) . DIRECTORY_SEPARATOR . 'models');
      $container->setParameter('subject_root', defined('SUBJECT_ROOT')
        ? SUBJECT_ROOT
        : rtrim($container->getParameter('Trupal_root')) . DIRECTORY_SEPARATOR . 'subjects');
      $container->setParameter('template_root', defined('TEMPLATE_ROOT')
        ? TEMPLATE_ROOT
        : rtrim($container->getParameter('Trupal_root')) . DIRECTORY_SEPARATOR . 'templates');

      $container->set('trupal', $this);
      $this->loadExtensions($loader);
    }
    catch (\Exception $e) {
      // TODO: Log error during container initialization.
      throw $e;
    }
//    finally {
//      $this->_container = $container;
//    }
    return $container;
  }

  /**
   * Load all extensions.
   *
   * @param \Symfony\Component\DependencyInjection\Loader\YamlFileLoader $service_loader
   *   A service file loader.
   */
  protected function loadExtensions(YamlFileLoader $service_loader) {
    foreach (['system', 'user'] as $ext_type) {
      $ext_root = self::EXT_ROOT . DIRECTORY_SEPARATOR . $ext_type;
      if (file_exists($ext_root)) {
        foreach (scandir($ext_root) as $ext_name) {
          if (!($ext_name === '.' || $ext_name === '..')) {
            $this->loadExtension($service_loader, $ext_name, $ext_type);
          }
        }
      }
    }
  }

  /**
   * Load the single extension with the given name and type.
   *
   * @param \Symfony\Component\DependencyInjection\Loader\YamlFileLoader $service_loader
   *   A service file service loader.
   * @param string $ext_name
   *   The name of the extension.
   * @param string $ext_type
   *   The extension type, either 'system' or 'user'.
   */
  protected function loadExtension(YamlFileLoader $service_loader, string $ext_name, string $ext_type) {
    $ext_dir = self::EXT_ROOT . DIRECTORY_SEPARATOR . $ext_type . DIRECTORY_SEPARATOR . $ext_name;
    if (file_exists($ext_dir) && is_dir($ext_dir)) {
      $service_file = $ext_dir . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'services.yml';
      if (file_exists($service_file)) {
        try {
          $service_loader->load($service_file);
        }
        catch (\Exception $e) {
          // @todo Handle the exception.
          return;
        }

      }
    }
  }

  /**
   * Retrieve the application container.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerBuilder
   *   A service container.
   */
  public static function container() {
    $instance = static::instance();
//    if (!isset($instance->_container)) {
//      $instance->initContainer();
//    }
    return $instance->_container;
  }

  /**
   * The file system service.
   *
   * @return \Trupal\Core\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem() {
    /** @var \Trupal\Core\os\FileSystem $file_system */
    $file_system = static::container()->get('file_system');
    return $file_system;
  }

  /**
   * The model manager service.
   *
   * @return \Trupal\Core\Model\ModelManagerInterface
   *   A model manager service instance.
   */
  public static function modelManager() {
    /** @var \Trupal\Core\Model\ModelManagerInterface $model_manager */
    $model_manager = static::container()->get('model.manager');
    return $model_manager;
  }

  /**
   * The model factory service.
   *
   * @return \Trupal\Core\Model\ModelFactory
   *   A model factory service instance.
   */
  public static function modelFactory() {
    /** @var \Trupal\Core\Model\ModelFactory $model_factory */
    $model_factory = static::container()->get('model.factory');
    return $model_factory;
  }

  /**
   * The project root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function root() {
    $root_path = $this->container()->getParameter('Trupal_ROOT');
    return $this->fileSystem()->dir($root_path);
  }

  /**
   * The model root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function modelRoot() {
    $model_root_path = $this->container()->getParameter('MODEL_ROOT');
    return $this->fileSystem()->dir($model_root_path);
  }

  /**
   * The subject root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function subjectRoot() {
    $subject_root_path = $this->container()->getParameter('SUBJECT_ROOT');
    return $this->fileSystem()->dir($subject_root_path);
  }

  /**
   * The template root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function templateRoot() {
    $template_root_path = $this->container()->getParameter('TEMPLATE_ROOT');
    return $this->fileSystem()->dir($template_root_path);
  }

  /**
   * The file parser manager service.
   *
   * @return \Trupal\Core\os\parse\FileParserManagerInterface
   *   A file parser manager service instance.
   */
  public static function fileParserManager() {
    /** @var \Trupal\Core\os\parse\FileParserManagerInterface $file_parser_manager */
    $file_parser_manager = static::container()->get('file_system.parse.manager');
    return $file_parser_manager;
  }

  /**
   * The subject discovery service.
   *
   * @return \Trupal\Core\Discovery\DiscoveryInterface
   *   A subject discovery service instance.
   */
  public static function subjectDiscovery() {
    /** @var \Trupal\Core\Discovery\DiscoveryInterface $subject_discovery */
    $subject_discovery = static::container()->get('subject.discovery');
    return $subject_discovery;
  }

  /**
   * The subject manager service.
   *
   * @return \Trupal\Core\Subject\SubjectManager
   *   A subject manager service instance.
   */
  public static function subjectManager() {
    /** @var \Trupal\Core\Subject\SubjectManager $subject_manager */
    $subject_manager = static::container()->get('subject.manager');
    return $subject_manager;
  }

  /**
   * The subject factory service.
   *
   * @return \Trupal\Core\Subject\SubjectFactory
   *   A subject factory service instance.
   */
  public static function subjectFactory() {
    /** @var \Trupal\Core\Subject\SubjectFactory $factory */
    $factory = static::container()->get('subject.factory');
    return $factory;
  }

  /**
   * Write tests for all discoverable subjects.
   *
   * @param \Trupal\Core\os\DirectoryInterface|string $subject_root
   *   The subject directory or path.
   * @param \Trupal\Core\os\DirectoryInterface|string $destination
   *   The output directory or path.
   *
   * @return array
   *   File paths to the generated test cases.
   */
  public function generate($subject_root, $destination) {
    $paths = [];

    if (is_string($destination)) {
      $destination = $this->fileSystem()->dir($destination);
    }

    // TODO: Allow passing of subject root directory as parameter.
    self::subjectDiscovery()->addDirectory($subject_root);
    foreach (self::subjectDiscovery()->discover() as $filepath) {
      if ($specification = $this->fileParserManager()->parse($filepath)) {
        if ($subject = $this->subjectFactory()->createFromSpecification($specification)) {
          if (($context = $this->contextFactory()->create($subject)) && ($content = $this->renderer()->render($context))) {
            $test_case = $destination->put("{$subject->getId()}.{$context->getOutputExtension()}");
            $test_case->setContent($content);
            $paths[] = $test_case->path();
          }
        }
      }
    }
    self::subjectDiscovery()->popDirectory();
    return $paths;
  }

  /**
   * The template locator service.
   *
   * @return \Trupal\Core\Discovery\DiscoveryInterface
   *   A template locator service instance.
   */
  public static function templateDiscovery() {
    /** @var \Trupal\Core\Discovery\DiscoveryInterface $template_discovery */
    $template_discovery = static::container()->get('render.template_discovery');
    return $template_discovery;
  }

  /**
   * The template finder service.
   *
   * @return \Trupal\Core\render\TemplateFinderInterface
   *   A template finder service instance.
   */
  public static function templateFinder() {
    /** @var \Trupal\Core\render\TemplateFinderInterface $template_finder */
    $template_finder = static::container()->get('render.template_finder');
    return $template_finder;
  }

  /**
   * The context factory service.
   *
   * @return \Trupal\Core\render\RenderContextFactoryInterface
   *   A render context factory service instance.
   */
  public static function contextFactory() {
    /** @var \Trupal\Core\render\RenderContextFactoryInterface $context_factory */
    $context_factory = static::container()->get('render.context_factory');
    return $context_factory;
  }

  /**
   * The printer service.
   *
   * @return \Trupal\Core\render\RendererInterface
   *   A renderer service instance.
   */
  public static function renderer() {
    /** @var \Trupal\Core\render\RendererInterface $renderer */
    $renderer = static::container()->get('render.renderer');
    return $renderer;
  }

  /**
   * The validator factory service.
   *
   * @return \Trupal\Core\Validation\ValidatorFactoryInterface
   *   A validator factory instance.
   */
  public static function validatorFactory() {
    /** @var \Trupal\Core\Validation\ValidatorFactoryInterface $factory */
    $factory = static::container()->get('validator.factory');
    return $factory;
  }

  /**
   * The filter factory service.
   *
   * @return \Trupal\Core\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A filter factory instance.
   */
  public static function directoryFilterFactory() {
    /** @var \Trupal\Core\Discovery\Filter\DirectoryFilterFactoryInterface $factory */
    $factory = static::container()->get('directory_filter.factory');
    return $factory;
  }

}
