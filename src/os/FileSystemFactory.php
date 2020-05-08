<?php

namespace Tozart\os;

class FileSystemFactory {

  // TODO: This is not a permanent solution.
  protected const CLASS_MAP = [
    'dir' => Directory::class,
    'file' => File::class,
    'yml' => YamlFile::class,
  ];

  public static function createDir($path) {
    $dir_class = self::CLASS_MAP['dir'];
    return new $dir_class($path);
  }

  public static function createFile($name, Directory $directory) {
    $file_path = $directory->systemPath() . $name;
    $extension = pathinfo($file_path, PATHINFO_EXTENSION);
    if ($extension && array_key_exists($extension, self::CLASS_MAP)) {
      $file_class = self::CLASS_MAP[$extension];
    }
    else {
      $file_class = self::CLASS_MAP['file'];
    }
    return new $file_class($name, $directory);
  }

}
