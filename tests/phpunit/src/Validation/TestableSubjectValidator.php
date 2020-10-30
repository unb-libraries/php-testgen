<?php

namespace Tozart\Test\Validation;

use Tozart\Discovery\FactoryInterface;
use Tozart\os\parse\FileParserInterface;
use Tozart\Validation\SubjectValidator;

/**
 * Subject validator without real behaviour, for testing purposes.
 *
 * @package Tozart\Test\Validation
 */
class TestableSubjectValidator extends SubjectValidator {

  /**
   * The model factory.
   *
   * @var \Tozart\Discovery\FactoryInterface
   */
  protected static $_modelFactory;

  /**
   * Retrieve the model factory.
   *
   * @return \Tozart\Discovery\FactoryInterface
   *   A factory object.
   */
  protected static function modelFactory() {
    return static::$_modelFactory;
  }

  /**
   * Create a new TestableSubjectValidator instance.
   *
   * @param \Tozart\os\parse\FileParserInterface $parser
   *   A file parser.
   * @param \Tozart\Discovery\FactoryInterface $model_factory
   *   A model factory.
   */
  public function __construct(FileParserInterface $parser, FactoryInterface $model_factory) {
    parent::__construct($parser);
    static::$_modelFactory = $model_factory;
  }

}
