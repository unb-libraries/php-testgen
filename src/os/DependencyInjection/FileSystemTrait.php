<?php

namespace Tozart\os\DependencyInjection;

use Tozart\Tozart;

/**
 * Dependency injection of the filesystem service.
 *
 * @package Tozart\os
 */
trait FileSystemTrait {

  /**
   * Inject the file system service.
   *
   * @return \Tozart\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem() {
    return Tozart::fileSystem();
  }

}
