<?php

namespace TestGen\os;

/**
 * Class to interact with a directory in the filesystem.
 *
 * @package TestGen\os
 */
class Directory extends \Directory {

  /**
   * The parent directory.
   *
   * @var Directory
   */
  protected $parent;

  /**
   * Iterator for directory content.
   *
   * @var \DirectoryIterator
   */
  protected $iterator;

  /**
   * Files in this directory.
   *
   * @var File[]
   */
  protected $files;

  /**
   * Create a new directory.
   *
   * @param $path
   *   The path to map to the directory instance. If pointing
   *   at a non-existing path, a new directory will be created.
   */
  public function __construct($path) {
    $this->path = $this->mapOrCreate($path);
  }

  /**
   * Resolve the path and map or create a directory.
   *
   * @param $path
   *   The path to map or under which to create the directory.
   *
   * @return string
   *   Resolved, absolute path to the directory. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   */
  protected function mapOrCreate($path) {
    if (empty($path)) {
      // TODO: This is not OS independent.
      $resolved_path = DIRECTORY_SEPARATOR;
    }
    else {
      if (!$resolved_path = \realpath($path)) {
        $segments = \explode(DIRECTORY_SEPARATOR, $path);

        $parent_segments = \array_slice(
          $segments, 0, count($segments) - 1
        );
        $unresolved_parent = \implode(
          DIRECTORY_SEPARATOR, $parent_segments
        );
        $parent = $this->mapOrCreate($unresolved_parent);
        $dirname = $segments[count($segments) - 1];

        $resolved_path =  $parent . $dirname;
        if (!\file_exists($resolved_path)) {
          $parent_permissions = self::unixPermissions($parent);
          \mkdir($resolved_path, $parent_permissions);
          \clearstatcache();
        }
      }
    }

    $resolved_path = \rtrim(
      $resolved_path, DIRECTORY_SEPARATOR
    ) . DIRECTORY_SEPARATOR;

    return $resolved_path;
  }

  /**
   * Absolute, system-wide path to the directory.
   *
   * @return string
   *   Absolute filesystem path string. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   *
   */
  public function systemPath() {
    return $this->path;
  }

  /**
   * Directory name as identified by its parent.
   *
   * @return string
   *   Relative filesystem path. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   */
  public function name() {
    $segments = \explode(DIRECTORY_SEPARATOR, $this->path);
    if (!empty($segments)) {
      $last_segment_index = \count($segments) - 1;
      $last_segment = $segments[$last_segment_index];
      if (empty($last_segment) && count($segments) > 1) {
        $last_segment = $segments[$last_segment_index -1];
      }
    } else {
      $last_segment = '';
    }
    return $last_segment . DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieves or creates an instance for the parent directory.
   *
   * @return Directory
   *   A Directory instance mapping the path to the parent.
   */
  public function parent() {
    if (!isset($this->parent)) {
      $this->parent = new static($this->parentPath());
    }
    return $this->parent;
  }

  /**
   * Retrieve the path to the parent without mapping to a new Directory instance.
   *
   * @return string
   *   Absolute filesystem path string. Ends with a path
   *   delimiter, i.e. '/' (Unix) or '\' (Windows).
   */
  public function parentPath() {
    if (isset($this->parent)) {
      $path = $this->parent->systemPath();
    }
    else {
      $segments = \explode(DIRECTORY_SEPARATOR, $this->systemPath());
      $base = \array_slice($segments, 0, \count($segments) - 2);
      $path = \implode(DIRECTORY_SEPARATOR, $base) . DIRECTORY_SEPARATOR;
    }
    return $path;
  }

  /**
   * Access permissions for the directory.
   *
   * @return int
   *   The directory's permissions as a numeric mode.
   *   @see \fileperms()
   *
   */
  public function permissions() {
    return self::unixPermissions($this->systemPath());
  }

  /**
   * Retrieve the permissions to the given path in UNIX format.
   *
   * @param $path
   *   The path for which to determine permissions.
   *
   * @return int
   *   Decimal that is equivalent to octal UNIX permissions.
   */
  private static function unixPermissions($path) {
    return \octdec(substr(sprintf('%o', \fileperms($path)), -3));
  }

  /**
   * Whether this directory can be written to.
   *
   * @return bool
   *   True if this directory allows write operations. False otherwise.
   */
  public function isWritable() {
    return \is_writable($this->systemPath());
  }

  /**
   * Put a file with the given name inside this directory.
   *
   * @param string $filename
   *   Filename without directory path.
   *
   * @return File|false
   *   A File instance. FALSE if directory is not writable.
   */
  public function put($filename) {
    if ($this->isWritable()) {
      if (!array_key_exists($filename, $this->files())) {
        $file = new File($filename, $this);
        $this->files[$filename] = $file;
      }
      return $this->files()[$filename];
    }
    return FALSE;
  }

  /**
   * Find the file instance with the given name inside this directory.
   *
   * @param string $filename
   *   Name of the file to find.
   *
   * @return File|false
   *   An instance of File, if one could be found. Otherwise FALSE.
   */
  public function find($filename) {
    if ($this->containsFile($filename)) {
      return $this->files()[$filename];
    }
    return FALSE;
  }

  /**
   * Whether a file with the given name exists inside this directory.
   *
   * @param string|File $file
   *   The file object or name to search for.
   *
   * @return bool
   *   TRUE if the given file instance or name is part of this directory. FALSE otherwise.
   */
  public function containsFile($file) {
    return is_string($file)
      ? array_key_exists($file, $this->files())
      : $this->containsFile($file->name());
  }

  /**
   * Retrieve all files contained in this directory.
   *
   * @return File[]
   *   Array of File instances.
   */
  public function files() {
    if (!isset($this->files)) {
      $this->files = [];
      $this->scan();
    }
    return $this->files;
  }

  /**
   * Scan the directory for files.
   */
  protected function scan() {
    foreach ($this->iterator() as $file) {
      if ($file->isFile() && !$file->isDot()) {
        $this->put($file->getFilename());
      }
    }
  }

  /**
   * Retrieve a DirectoryIterator to iterator over this directory's content.
   *
   * @return \DirectoryIterator
   *   A DirectoryIterator instance.
   */
  protected function iterator() {
    if (!isset($this->iterator)) {
      $this->iterator = new \DirectoryIterator($this->systemPath());
    }
    return $this->iterator;
  }

  /**
   * Join the directory's path with the given path.
   *
   * @param string $path
   *   Relative path from within this directory.
   *
   * @return string
   *   Absolute filesystem path.
   */
  public function join($path) {
    return $this->path . $path;
  }

}