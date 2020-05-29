<?php

namespace Tozart\os;

/**
 * Class reflecting the file system.
 *
 * @package Tozart\os
 */
class FileSystem {

  /**
   * An array of file types known to the file system.
   *
   * @var \Tozart\os\FileType[]
   */
  protected $_fileTypes;

  // TODO: This is not a permanent solution.
  protected const CLASS_MAP = [
    'dir' => Directory::class,
    'file' => File::class,
    'yml' => YamlFile::class,
  ];

  /**
   * Create a new FileSystem instance.
   *
   * @param \Tozart\os\FileType[] $file_types
   *   An array of supported file types.
   */
  public function __construct(array $file_types) {
    $this->_fileTypes = $file_types;
  }

  public function dir($path) {
    $dir_class = self::CLASS_MAP['dir'];
    return new $dir_class($path);
  }

  public function file($name, Directory $directory) {
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

  /**
   * Retrieve all file types known to the file system.
   *
   * @return \Tozart\os\FileType[]
   *   An array of file type objects.
   */
  public function fileTypes() {
    return $this->_fileTypes;
  }

}
