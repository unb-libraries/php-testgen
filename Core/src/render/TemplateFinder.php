<?php

namespace Trupal\Core\render;

use Trupal\Core\Discovery\DiscoveryInterface;
use Trupal\Core\os\FileInterface;
use Trupal\Core\Subject\SubjectInterface;

/**
 * Class for retrieving the best matching template for a given subject.
 *
 * @package Trupal\Core\render
 */
class TemplateFinder implements TemplateFinderInterface {

  /**
   * The template discovery.
   *
   * @var \Trupal\Core\Discovery\DiscoveryInterface
   */
  protected $templateDiscovery;

  /**
   * The directories to search in.
   *
   * @var \Trupal\Core\os\DirectoryInterface[]
   */
  protected $directories;

  /**
   * Retrieve the template discovery.
   *
   * @return \Trupal\Core\Discovery\DiscoveryInterface
   *   A template discovery object.
   */
  protected function templateDiscovery() {
    return $this->templateDiscovery;
  }

  /**
   * Retrieve the directories to search in. Sorted by relevance.
   *
   * @return \Trupal\Core\os\DirectoryInterface[]
   *   An array of directories, keyed by each directory's path.
   */
  protected function directories() {
    if (empty($this->directories)) {
      $this->directories = [];
      foreach (array_reverse($this->templateDiscovery()->directoryStack()) as $directory) {
        $this->directories[$directory->systemPath()] = $directory;
      }
    }
    return $this->directories;
  }

  /**
   * Create a new TemplateFinder instance.
   *
   * @param \Trupal\Core\Discovery\DiscoveryInterface $template_discovery
   *   A template discovery object.
   */
  public function __construct(DiscoveryInterface $template_discovery) {
    $this->templateDiscovery = $template_discovery;
  }

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
  public function findTemplate(SubjectInterface $subject) {
    $best_match = [];
    foreach ($templates = $this->templateDiscovery()->discover() as $id => $template) {
      $score = $this->calculateScore($template, $subject);
      if ($score && (empty($best_match) || $best_match['score'] < $score)) {
        $best_match = [
          'score' => $score,
          'template' => $template,
        ];
      }
    }

    if (!empty($best_match)) {
      return $best_match['template'];
    }
    return FALSE;
  }

  /**
   * Calculate a score value indicating how well suitable the given template file is to render the given subject.
   *
   * @param \Trupal\os\FileInterface $file
   *   The template file.
   * @param \Trupal\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return float|int
   *   A number > 0 indicates that the file can be used to render
   *   the given subject. The higher the number the more it is
   *   suitable to render the subject. 0 indicates that the file
   *   is not suitable.
   */
  protected function calculateScore(FileInterface $file, SubjectInterface $subject) {
    $score = 0;
    $directories = $this->directories();
    $patterns = array_values(array_reverse($subject->getTemplateDiscoveryPatterns()));

    foreach ($patterns as $index => $pattern) {
      if (preg_match($pattern, $file->name())) {
        $pattern_relevance = $index + 1;
        $directory_relevance = array_search($file->directory()->systemPath(), array_keys($directories));

        $pattern_score = count($directories) * $pattern_relevance + $directory_relevance;
        if ($pattern_score > $score) {
          $score = $pattern_score;
        }
      }
    }
    return $score;
  }

}
