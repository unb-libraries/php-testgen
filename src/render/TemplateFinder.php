<?php

namespace Tozart\render;

use Tozart\Discovery\DiscoveryInterface;
use Tozart\os\FileInterface;
use Tozart\Subject\SubjectInterface;

/**
 * Class for retrieving the best matching template for a given subject.
 *
 * @package Tozart\render
 */
class TemplateFinder implements TemplateFinderInterface {

  /**
   * The template discovery.
   *
   * @var \Tozart\Discovery\DiscoveryInterface
   */
  protected $templateDiscovery;

  /**
   * Retrieve the template discovery.
   *
   * @return \Tozart\Discovery\DiscoveryInterface
   *   A template discovery object.
   */
  protected function templateDiscovery() {
    return $this->templateDiscovery;
  }

  /**
   * Create a new TemplateFinder instance.
   *
   * @param \Tozart\Discovery\DiscoveryInterface $template_discovery
   *   A template discovery object.
   */
  public function __construct(DiscoveryInterface $template_discovery) {
    $this->templateDiscovery = $template_discovery;
  }

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
  public function findTemplate(SubjectInterface $subject) {
    $scores = [];
    foreach ($this->templateDiscovery()->discover() as $template) {
      if ($score = $this->calculateScore($template, $subject)) {
        $scores[$template->name()] = $score;
      }
    }

    if (!empty($scores)) {
      arsort($scores, SORT_NUMERIC);
      return $scores[array_keys($scores)[0]];
    }
    return FALSE;
  }

  /**
   * Calculate a score value indicating how well suitable the given template file is to render the given subject.
   *
   * @param \Tozart\os\FileInterface $file
   *   The template file.
   * @param \Tozart\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return float|int
   *   A number > 0 indicates that the file can be used to render
   *   the given subject. The higher the number the more it is
   *   suitable to render the subject. 0 indicates that the file
   *   is not suitable.
   */
  protected function calculateScore(FileInterface $file, SubjectInterface $subject) {
    $patterns = $subject->getTemplateDiscoveryPatterns();
    $directories = $this->templateDiscovery()->directoryStack();
    foreach (array_values($patterns) as $index => $pattern) {
      if (preg_match($pattern, $file->name())) {
        $pattern_factor = count($patterns) - $index - 1;
        $directory_factor = array_keys(array_filter($directories, function ($directory) use ($file) {
          return $directory->systemPath() === $file->directory()->systemPath();
        }))[0];
        return count($directories) * $pattern_factor + $directory_factor;
      }
    }
    return 0;
  }

}
