<?php

namespace Tozart\os\parse;

use Symfony\Component\Yaml\Yaml;
use Tozart\os\File;

/**
 * YAML file parser implementation.
 *
 * @package Tozart\os\parse
 */
class YamlParser implements FileParserInterface {

  /**
   * {@inheritDoc}
   */
  public function fileTypes() {
    return [
      'yml',
      'yaml',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function parse(File $file) {
    return Yaml::parseFile($file->path());
  }

}
