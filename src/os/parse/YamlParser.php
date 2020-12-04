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
    return 'yaml';
  }

  public static function getSpecification() {
    return [
      'file_type' => 'yaml',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function parse($filepath) {
    return Yaml::parseFile($filepath);
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
