<?php

namespace Tozart\os\DependencyInjection;

use Tozart\Tozart;

/**
 * Inject the filesystem service.
 *
 * @package Tozart\os
 */
trait FileSystemTrait {

  /**
   * The file system service.
   *
   * @return \Tozart\os\FileSystem
   *   A file system service instance.
   */
  public static function fileSystem() {
    return Tozart::fileSystem();
  }

}
