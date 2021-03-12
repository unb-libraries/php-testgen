<?php

namespace Trupal\Core\Test\Validation;

use Trupal\Core\Discovery\FactoryInterface;
use Trupal\Core\os\parse\FileParserInterface;
use Trupal\Core\Validation\SubjectValidator;

/**
 * Subject validator without real behaviour, for testing purposes.
 *
 * @package Trupal\Core\Test\Validation
 */
class TestableSubjectValidator extends SubjectValidator {

  /**
   * The model factory.
   *
   * @var \Trupal\Core\Discovery\FactoryInterface
   */
  protected static $_modelFactory;

  /**
   * Retrieve the model factory.
   *
   * @return \Trupal\Core\Discovery\FactoryInterface
   *   A factory object.
   */
  protected static function modelFactory() {
    return static::$_modelFactory;
  }

  /**
   * Create a new TestableSubjectValidator instance.
   *
   * @param \Trupal\Core\os\parse\FileParserInterface $parser
   *   A file parser.
   * @param \Trupal\Core\Discovery\FactoryInterface $model_factory
   *   A model factory.
   */
  public function __construct(FileParserInterface $parser, FactoryInterface $model_factory) {
    parent::__construct($parser);
    static::$_modelFactory = $model_factory;
  }

}
