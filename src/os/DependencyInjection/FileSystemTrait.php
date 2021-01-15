<?php

namespace Trupal\os\DependencyInjection;

use Trupal\Trupal;

/**
 * Dependency injection of the filesystem service.
 *
 * @package Trupal\os
 */
trait FileSystemTrait {

  /**
   * Inject the file system service.
   *
   * @return \Trupal\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem() {
    return Trupal::fileSystem();
  }

}
