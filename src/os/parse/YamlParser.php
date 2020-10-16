<?php

namespace Tozart\os\parse;

use Symfony\Component\Yaml\Yaml;
use Tozart\os\FileInterface;
use Tozart\Tozart;

/**
 * File parser for YAML files.
 *
 * @package Tozart\os\parse
 */
class YamlParser implements FileParserInterface {

  public static function getId() {
    return 'yml';
  }

  public static function getSpecification() {
    return [
      'file_type' => 'yml',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function parse(FileInterface $file) {
    return Yaml::parseFile($file->path());
  }

  /**
   * {@inheritDoc}
   */
  public function getSupportedTypes() {
    return [
      Tozart::container()
        ->get('file_system.file_type.yaml'),
    ];
  }

}
