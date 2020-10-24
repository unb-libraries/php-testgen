<?php

namespace Tozart\render;

use Tozart\os\FileInterface;
use Tozart\Subject\SubjectInterface;

/**
 * Interface for template finders.
 *
 * @package Tozart\render
 */
interface TemplateFinderInterface {

  /**
   * Find a suitable template to render the given subject.
   *
   * @param \Tozart\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return FileInterface|false
   *   A template file. FALSE if no suitable template could
   *   be located.
   */
  public function findTemplate(SubjectInterface $subject);

}
