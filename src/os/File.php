<?php

namespace Tozart\os;

use Tozart\os\DependencyInjection\FileSystemTrait;

/**
 * Class to interact with a file in the filesystem.
 *
 * @package Tozart\os
 */
class File implements FileInterface {

  use FileSystemTrait;

  /**
   * Name of the file.
   *
   * @var string
   */
  protected $name;

  /**
   * The directory which contains the file.
   *
   * @var \Tozart\os\DirectoryInterface
   */
  protected $directory;

  /**
   * The type of the file.
   *
   * @var \Tozart\os\FileTypeInterface
   */
  protected $type;

  /**
   * Handle to the file.
   *
   * @var resource
   */
  protected $handle;

  /**
   * {@inheritDoc}
   */
  public function name() {
    return $this->name;
  }

  /**
   * {@inheritDoc}
   */
  public function path() {
    return $this->directory()->systemPath() . $this->name();
  }

  /**
   * {@inheritDoc}
   */
  public function extension() {
    return \pathinfo($this->path())['extension'];
  }

  /**
   * {@inheritDoc}
   */
  public function permissions() {
    return \octdec(substr(sprintf('%o', \fileperms($this->path())), -3));
  }

  /**
   * {@inheritDoc}
   */
  public function directory() {
    return $this->directory;
  }

  /**
   * {@inheritDoc}
   */
  public function parse() {
    $parser = $this->type()->getParser();
    return $parser->parse($this->path());
  }

  /**
   * {@inheritDoc}
   */
  public function type() {
    return $this->type;
  }

  /**
   * Retrieve the file handle.
   *
   * @return resource
   *   A handle.
   */
  protected function handle() {
    if (!isset($this->handle)) {
      if (\file_exists($this->path())) {
        $this->handle = \fopen($this->path(), 'a+');
      }
      else {
        $this->handle = \fopen($this->path(), 'x+');
        \chmod($this->path(), $this->directory()->permissions());
        \clearstatcache();
      }
    }
    return $this->handle;
  }

  /**
   * Create a new file.
   *
   * @param string $name
   *   Name of the file.
   * @param \Tozart\os\DirectoryInterface $directory
   *   Directory which contains the file.
   */
  public function __construct($name, DirectoryInterface $directory) {
    $this->name = $name;
    $this->directory = $directory;
    $this->handle = $this->handle();
    $this->type = $this->fileSystem()
      ->getFileType($this->extension());
  }

  /**
   * {@inheritDoc}
   */
  public function content() {
    return \file_get_contents($this->path());
  }

  /**
   * {@inheritDoc}
   */
  public function setContent($content, $mode = self::CONTENT_REPLACE) {
    switch ($mode) {
      case self::CONTENT_APPEND:
        \fwrite($this->handle(), $content);
        break;

      default:
        \file_put_contents($this->path(), $content);
    }
  }

  /**
   * {@inheritDoc}
   */
  public function copy(DirectoryInterface $destination, $name = '', $override = TRUE) {
    if (!$name) {
      $name = $this->name();
    }
    if ($override || !$destination->containsFile($name)) {
      if ($copy = $destination->put($name)) {
        $copy->setContent($this->content());
        return $copy;
      }
    }
    return NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function __toString() {
    return $this->path();
  }

}
