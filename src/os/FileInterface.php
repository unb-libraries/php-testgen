<?php

namespace Tozart\os;

/**
 * Interface for file objects.
 *
 * @package Tozart\os
 */
interface FileInterface {

  const CONTENT_REPLACE = 0;
  const CONTENT_APPEND = 1;

  /**
   * Retrieve the name of the file.
   *
   * @return string
   *   A string.
   */
  public function name();

  /**
   * Retrieve the path to the file.
   *
   * @return string
   *   A string which represents an absolute filesystem path.
   */
  public function path();

  /**
   * Retrieve the file extension.
   *
   * @return string
   *   A file extension string, e.g. "php".
   */
  public function extension();

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
   * Retrieve the directory.
   *
   * @return \Tozart\os\DirectoryInterface
   *   A Directory instance.
   */
  public function directory();

  /**
   * Parse the file by an appropriate parser according to its file type.
   *
   * @return mixed
   *   The parsed content.
   */
  public function parse();

  /**
   * Retrieve the file's type.
   *
   * @return \Tozart\os\FileTypeInterface
   *   A file type object.
   */
  public function type();

  /**
   * Retrieve the file contents.
   *
   * @return string
   *   String containing the complete content of the file.
   */
  public function content();

  /**
   * Fill the file with the given content.
   *
   * @param string $content
   *   A string.
   * @param int $mode
   *   How to treat existing content.
   */
  public function setContent($content, $mode = self::CONTENT_REPLACE);

  /**
   * Copy the file to the given destination.
   *
   * @param \Tozart\os\DirectoryInterface $destination
   *   A Directory instance.
   * @param string $name
   *   (optional) The name to use at the destination.
   *   If left blank, the same name as the source will be used.
   * @param bool $override
   *   (optional) Whether to override any existing files.
   *
   * @return \Tozart\os\FileInterface
   *   The duplicated file.
   */
  public function copy(DirectoryInterface $destination, $name = '', $override = TRUE);

  /**
   * String representation of the file.
   *
   * @return string
   *   A file path string.
   */
  public function __toString();

}
