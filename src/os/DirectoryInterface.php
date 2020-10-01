<?php

namespace Tozart\os;

interface DirectoryInterface {

  /**
   * Absolute, system-wide path to the directory.
   *
   * @return string
   *   Absolute filesystem path string. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   *
   */
  public function systemPath();

  /**
   * Directory name as identified by its parent.
   *
   * @return string
   *   Relative filesystem path. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   */
  public function name();

  /**
   * Retrieves or creates an instance for the parent directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A Directory instance mapping the path to the parent.
   */
  public function parent();

  /**
   * Retrieve the path to the parent without mapping to a new Directory instance.
   *
   * @return string
   *   Absolute filesystem path string. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   */
  public function parentPath();

  /**
   * Access permissions for the directory.
   *
   * @return int
   *   The directory's permissions as a numeric mode.
   *   @see \fileperms()
   *
   */
  public function permissions();

  /**
   * Whether this directory can be written to.
   *
   * @return bool
   *   True if this directory allows write operations. False otherwise.
   */
  public function isWritable();

  /**
   * Put a file with the given name inside this directory.
   *
   * @param string $filename
   *   Filename without directory path.
   *
   * @return File|false
   *   A File instance. FALSE if directory is not writable.
   */
  public function put($filename);

  /**
   * Find the file instance with the given name inside this directory.
   *
   * @param string $filename
   *   Name of the file to find.
   *
   * @return File|false
   *   An instance of File, if one could be found. Otherwise FALSE.
   */
  public function find($filename);

  /**
   * Whether a file with the given name exists inside this directory.
   *
   * @param string|File $file
   *   The file object or name to search for.
   *
   * @return bool
   *   TRUE if the given file instance or name is part of this directory. FALSE otherwise.
   */
  public function containsFile($file);

  /**
   * Retrieve all files contained in this directory.
   *
   * @return File[]
   *   Array of File instances.
   */
  public function files();

  /**
   * Join the directory's path with the given path.
   *
   * @param string $path
   *   Relative path from within this directory.
   *
   * @return string
   *   Absolute filesystem path.
   */
  public function join($path);

}
