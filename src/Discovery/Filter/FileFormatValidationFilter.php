<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\File;
use Tozart\os\FileTypeInterface;
use Tozart\Validation\ValidatorFactoryTrait;

/**
 * Filter for sorting out (structured) files that have an invalid format.
 *
 * @package Tozart\Discovery\Filter
 */
class FileFormatValidationFilter extends FileTypeFilter {

  use ValidatorFactoryTrait;

  /**
   * The validator.
   *
   * @var \Tozart\Validation\ValidatorInterface
   */
  protected $_validator;

  /**
   * Retrieve the validator.
   *
   * @return \Tozart\Validation\ValidatorInterface
   *   A validator object.
   */
  protected function validator() {
    return $this->_validator;
  }

  /**
   * Create a new FileFormatValidationFilter instance.
   *
   * @param \Tozart\os\FileTypeInterface $file_type
   *   The file type that determines the required format.
   */
  public function __construct(FileTypeInterface $file_type) {
    parent::__construct($file_type);
    $this->_validator = static::validatorFactory()
      ->create('file_format', ['file_type' => $file_type]);
  }

  /**
   * {@inheritDoc}
   */
  public static function create(array $configuration) {
    return new static($configuration['file_type']);
  }

  /**
   * {@inheritDoc}
   */
  public static function getId() {
    return 'file_format';
  }

  /**
   * {@inheritDoc}
   */
  public static function getSpecification() {
    return [
      'file_type' => 'yml',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function evaluate(File $file) {
    if ($pass = parent::evaluate($file)) {
      $pass = empty($validation_errors = $this->validator()
        ->validate($file));
    }
    return $pass;
  }

}
