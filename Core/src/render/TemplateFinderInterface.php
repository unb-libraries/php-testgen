<?php

namespace Trupal\Core\render;

use Trupal\Core\os\FileInterface;
use Trupal\Core\Subject\SubjectInterface;

/**
 * Interface for template finders.
 *
 * @package Trupal\Core\render
 */
interface TemplateFinderInterface {

  /**
   * Find a suitable template to render the given subject.
   *
   * @param \Trupal\Core\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return FileInterface|false
   *   A template file. FALSE if no suitable template could
   *   be located.
   */
  public function findTemplate(SubjectInterface $subject);

}
