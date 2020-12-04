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
   * @var \Tozart\os\FileTypeInterface[]
   */
  protected $_fileTypes = [];

  /**
   * Retrieve all file types known to the file system.
   *
   * @return \Tozart\os\FileTypeInterface[]
   *   An array of file type objects.
   */
  public function fileTypes() {
    return $this->_fileTypes;
  }

  /**
   * Add the given file type.
   *
   * @param \Tozart\os\FileTypeInterface $file_type
   *   A file type object.
   */
  public function addFileType(FileTypeInterface $file_type) {
    $this->_fileTypes[strtolower($file_type->getName())] = $file_type;
  }

  /**
   * Create a new FileSystem instance.
   *
   * @param \Tozart\os\FileTypeInterface[] $file_types
   *   An array of supported file types.
   */
  public function __construct(array $file_types) {
    foreach ($file_types as $file_type) {
      $this->addFileType($file_type);
    }
  }

  /**
   * Retrieve a file type object with the given name or extension.
   *
   * @param string $name_or_extension
   *   A file type name or extension.
   *
   * @return \Tozart\os\FileTypeInterface|null
   *   A file type object. NULL if no file type
   *   could be found for the given parameters.
   */
  public function getFileType(string $name_or_extension) {
    $name_or_extension = strtolower($name_or_extension);
    if (array_key_exists($name_or_extension, $this->fileTypes())) {
      return $this->fileTypes()[$name_or_extension];
    }
    else {
      foreach ($this->fileTypes() as $file_type) {
        if (in_array($name_or_extension, $file_type->getExtensions())) {
          return $file_type;
        }
      }
    }
    return NULL;
  }

  /**
   * Retrieve a directory instance reflecting the given path.
   *
   * @param string $path
   *   The path to the directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A directory object.
   */
  public function dir(string $path) {
    return new Directory($path);
  }

  /**
   * Retrieve a file instance reflecting the given name and directory.
   *
   * @param string $path
   *   The name of the file.
   * @param \Tozart\os\DirectoryInterface|string $directory
   *   The directory.
   * @param bool $absolute
   *   Whether the given path is absolute.
   *
   * @return \Tozart\os\FileInterface
   *   A file object.
   */
  public function file($path, $directory = DIRECTORY_SEPARATOR, $absolute = FALSE) {
    if ($absolute) {
      $segments = explode(DIRECTORY_SEPARATOR, $path);
      // TODO: Creation of an absolute directory path should be platform independent.
      $directory = DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array_splice($segments, 0, -1));
      $path = $segments[0];
    }

    if (is_string($directory)) {
      $directory = $this->dir($directory);
    }
    return new File($path, $directory);
  }



}
