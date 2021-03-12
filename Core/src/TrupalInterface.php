<?php

namespace Trupal\Core;

/**
 * Interface for the Trupal root.
 *
 * @package Trupal
 */
interface TrupalInterface {

  /**
   * Create (or retrieve) the only Trupal that should ever exist.
   *
   * @return \Trupal\Core\Trupal
   *   A Trupal instance.
   */
  public static function instance();

  /**
   * Retrieve the application container.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerInterface
   *   A service container.
   */
  public static function container();

  /**
   * The file system service.
   *
   * @return \Trupal\Core\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem();

  /**
   * The model manager service.
   *
   * @return \Trupal\Core\Model\ModelManagerInterface
   *   A model manager service instance.
   */
  public static function modelManager();

  /**
   * The model factory service.
   *
   * @return \Trupal\Core\Model\ModelFactory
   *   A model factory service instance.
   */
  public static function modelFactory();

  /**
   * The project root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function root();

  /**
   * The model root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function modelRoot();

  /**
   * The subject root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function subjectRoot();

  /**
   * The template root directory.
   *
   * @return \Trupal\Core\os\DirectoryInterface
   *   A directory object.
   */
  public function templateRoot();

  /**
   * The file parser manager service.
   *
   * @return \Trupal\Core\os\parse\FileParserManagerInterface
   *   A file parser manager service instance.
   */
  public static function fileParserManager();

  /**
   * The subject discovery service.
   *
   * @return \Trupal\Core\Discovery\DiscoveryInterface
   *   A subject discovery service instance.
   */
  public static function subjectDiscovery();

  /**
   * The subject manager service.
   *
   * @return \Trupal\Core\Subject\SubjectManager
   *   A subject manager service instance.
   */
  public static function subjectManager();

  /**
   * The subject factory service.
   *
   * @return \Trupal\Core\Subject\SubjectFactory
   *   A subject factory service instance.
   */
  public static function subjectFactory();

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
  public function generate($subject_root, $destination);

  /**
   * The template locator service.
   *
   * @return \Trupal\Core\Discovery\DiscoveryInterface
   *   A template locator service instance.
   */
  public static function templateDiscovery();

  /**
   * The template finder service.
   *
   * @return \Trupal\Core\render\TemplateFinderInterface
   *   A template finder service instance.
   */
  public static function templateFinder();

  /**
   * The context factory service.
   *
   * @return \Trupal\Core\render\RenderContextFactoryInterface
   *   A render context factory service instance.
   */
  public static function contextFactory();

  /**
   * The printer service.
   *
   * @return \Trupal\Core\render\RendererInterface
   *   A renderer service instance.
   */
  public static function renderer();

  /**
   * The validator factory service.
   *
   * @return \Trupal\Core\Validation\ValidatorFactoryInterface
   *   A validator factory instance.
   */
  public static function validatorFactory();

  /**
   * The filter factory service.
   *
   * @return \Trupal\Core\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A filter factory instance.
   */
  public static function directoryFilterFactory();

}
