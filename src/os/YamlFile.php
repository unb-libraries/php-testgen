<?php

namespace TestGen\os;

use Symfony\Component\Yaml\Yaml;

/**
 * Class to process a YAML file.
 * @package TestGen\os
 */
class YamlFile extends ParsableFile {

  /**
   * {@inheritDoc}
   */
  public function parse() {
    try {
      return Yaml::parse($this->content());
    }
    catch (\Exception $e) {
      return NULL;
    }
  }

}
