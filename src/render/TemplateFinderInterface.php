<?php

namespace Trupal\render;

use Trupal\os\FileInterface;
use Trupal\Subject\SubjectInterface;

/**
 * Interface for template finders.
 *
 * @package Trupal\render
 */
interface TemplateFinderInterface {

  /**
   * Find a suitable template to render the given subject.
   *
   * @param \Trupal\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return FileInterface|false
   *   A template file. FALSE if no suitable template could
   *   be located.
   */
  public function findTemplate(SubjectInterface $subject);

}
