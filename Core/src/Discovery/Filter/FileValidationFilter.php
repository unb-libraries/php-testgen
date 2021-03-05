<?php

namespace Trupal\Core\Discovery\Filter;

use Trupal\os\FileInterface;
use Trupal\Validation\ValidatorInterface;

/**
 * Filter for sorting out files which a configured validator does not validate.
 *
 * @package Trupal\Discovery\Filter
 */
class FileValidationFilter implements DirectoryFilterInterface {

  /**
   * The validator.
   *
   * @var \Trupal\Validation\ValidatorInterface
   */
  protected $_validator;

  /**
   * Retrieve the validator.
   *
   * @return \Trupal\Validation\ValidatorInterface
   *   A validator object.
   */
  public function getValidator() {
    return $this->_validator;
  }

  /**
   * Create a new FileValidationFilter instance.
   *
   * @param \Trupal\Validation\ValidatorInterface $validator
   *   A validator object.
   */
  public function __construct(ValidatorInterface $validator) {
    $this->_validator = $validator;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(array $configuration) {
    return new static($configuration['validator']);
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'validate';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [
      'validator' => 'file_format',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function evaluate(FileInterface $file) {
    return $this->getValidator()->validate($file);
  }

}
