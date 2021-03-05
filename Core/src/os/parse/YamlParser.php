<?php

namespace Trupal\Core\os\parse;

use Symfony\Component\Yaml\Yaml;
use Trupal\Core\os\FileInterface;
use Trupal\Core\Trupal;

/**
 * File parser for YAML files.
 *
 * @package Trupal\Core\os\parse
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
