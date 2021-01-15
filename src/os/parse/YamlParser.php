<?php

namespace Trupal\os\parse;

use Symfony\Component\Yaml\Yaml;
use Trupal\os\FileInterface;
use Trupal\Trupal;

/**
 * File parser for YAML files.
 *
 * @package Trupal\os\parse
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
      Trupal::container()
        ->get('file_system.file_type.yaml'),
    ];
  }

}
