<?php

namespace Trupal\Core\os\DependencyInjection;

use Trupal\Core\Trupal;

/**
 * Dependency injection of the filesystem service.
 *
 * @package Trupal\Core\os
 */
trait FileSystemTrait {

  /**
   * Inject the file system service.
   *
   * @return \Trupal\Core\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem() {
    return Trupal::fileSystem();
  }

}
