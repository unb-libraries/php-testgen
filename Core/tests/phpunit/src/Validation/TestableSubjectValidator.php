<?php

namespace Trupal\Test\Validation;

use Trupal\Discovery\FactoryInterface;
use Trupal\os\parse\FileParserInterface;
use Trupal\Validation\SubjectValidator;

/**
 * Subject validator without real behaviour, for testing purposes.
 *
 * @package Trupal\Test\Validation
 */
class TestableSubjectValidator extends SubjectValidator {

  /**
   * The model factory.
   *
   * @var \Trupal\Discovery\FactoryInterface
   */
  protected static $_modelFactory;

  /**
   * Retrieve the model factory.
   *
   * @return \Trupal\Discovery\FactoryInterface
   *   A factory object.
   */
  protected static function modelFactory() {
    return static::$_modelFactory;
  }

  /**
   * Create a new TestableSubjectValidator instance.
   *
   * @param \Trupal\os\parse\FileParserInterface $parser
   *   A file parser.
   * @param \Trupal\Discovery\FactoryInterface $model_factory
   *   A model factory.
   */
  public function __construct(FileParserInterface $parser, FactoryInterface $model_factory) {
    parent::__construct($parser);
    static::$_modelFactory = $model_factory;
  }

}
