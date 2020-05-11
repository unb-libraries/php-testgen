<?php

namespace Tozart\render;

use Tozart\os\DependencyInjection\FileSystemTrait;
use Tozart\os\Directory;
use Tozart\Subject\SubjectBase;

/**
 * A TemplateLocator finds suitable templates for subjects.
 *
 * @package Tozart\render
 */
class TemplateLocator {

  use FileSystemTrait;

  /**
   * The directory roots to scan for template files.
   *
   * @var \Tozart\os\Directory[]
   */
  protected $_templateRoots;

  /**
   * The filename patterns.
   *
   * @var array
   */
  protected $_patterns;

  /**
   * Retrieve the directory roots to scan for template files.
   *
   * @return \Tozart\os\Directory[]
   *   An array of directory instances.
   */
  public function templateRoots() {
    return $this->_templateRoots;
  }

  /**
   * Retrieve the filename patterns.
   *
   * @return array
   *   An array of strings.
   *
   * @see \Tozart\render\TemplateLocator::compilePattern()
   */
  public function patterns() {
    return $this->_patterns;
  }

  /**
   * Creates a new TemplateLocator instance.
   *
   * @param array $template_roots
   *   An array of directories or directory paths.
   * @param array $patterns
   *   An array of filename patterns.
   *
   * @see \Tozart\render\TemplateLocator::compilePattern().
   */
  public function __construct(array $template_roots, array $patterns) {
    foreach ($template_roots as $template_root) {
      $this->addTemplateRoot($template_root);
    }
    $this->_patterns = $patterns;
  }

  /**
   * Add a template root directory.
   *
   * @param mixed $template_root
   *   A directory or path to a directory.
   * @param int $weight
   *   (optional) An integer indicating at which
   *   position in the collection the new template root
   *   folder should be inserted.
   *
   *   When locating templates, those found in folders at
   *   the front of the collection will be given priority
   *   over those at the back of the collection.
   *
   *   The default value is 0 (i.e. insert at front).
   */
  public function addTemplateRoot($template_root, $weight = 0) {
    if (is_string($template_root)) {
      $template_root = $this->fileSystem()->dir($template_root);
    }

    $template_roots = $this->templateRoots();
    if ($weight >= 0) {
      array_unshift($paths = array_keys($template_roots), $template_root->systemPath());
      array_unshift($dirs = array_values($template_roots), $template_root);
      $template_roots = array_combine($paths, $dirs);
    }
    elseif ($weight >= count($template_roots)) {
      $template_roots[$template_root->systemPath()] = $template_root;
    }
    else {
      array_splice($paths = array_keys($template_roots), $weight, 0, [$template_root->systemPath()]);
      array_splice($dirs = array_values($template_roots), $weight, 0, [$template_root]);
      $template_roots = array_combine($paths, $dirs);
    }

    $this->_templateRoots = $template_roots;
  }

  /**
   * Locate a template for the given subject.
   *
   * @param \Tozart\Subject\SubjectBase $subject
   *   The subject.
   *
   * @return \Tozart\os\File
   *   A template file. If more than one template is located that
   *   matches one of the locator's patterns, the one matching the
   *   highest-priority-pattern in the highest-priority-folder
   *   will be returned.
   */
  public function getTemplate(SubjectBase $subject) {
    if (!empty($templates = $this->findTemplates($subject))) {
      $this->prioritize($templates);
      return array_values(array_values($templates)[0])[0];
    }
    return NULL;
  }

  /**
   * Scan all template roots for templates that are suitable for the given subject.
   *
   * @param \Tozart\Subject\SubjectBase $subject
   *   The subject.
   *
   * @return \Tozart\os\File[]
   *   An array of files objects, keyed by their names.
   */
  public function findTemplates(SubjectBase $subject) {
    $templates = [];
    $compiled_patterns = $this->compilePatterns($subject);
    foreach ($this->templateRoots() as $template_root) {
      $matches = $this->match($template_root, $compiled_patterns);
      foreach ($matches as $compiled_pattern => $file) {
        $raw_pattern = array_keys($compiled_patterns)[$compiled_pattern];
        $templates[$raw_pattern][] = $file;
      }
    }
    return $templates;
  }

  /**
   * Sort the given templates by the priority that was given to the pattern which each of them match.
   *
   * @param \Tozart\os\File[] $templates
   *   An array of template files.
   */
  protected function prioritize(&$templates) {
    $priorities = array_flip($this->patterns());
    usort($templates, function ($pattern1, $pattern2) use ($priorities) {
      return $priorities[$pattern1] - $priorities[$pattern2];
    });
  }

  /**
   * Compile all patterns.
   *
   * @param \Tozart\Subject\SubjectBase $subject
   *   The subject.
   *
   * @return array
   *   An array of the form ORIGINAL_PATTERN => COMPILED_PATTERN.
   */
  protected function compilePatterns(SubjectBase $subject) {
    $patterns = [];
    foreach ($this->patterns() as $pattern) {
      if ($compiled_pattern = $this->compilePattern($pattern, $subject)) {
        $patterns[$pattern] = $compiled_pattern;
      }
    }
    return $patterns;
  }

  /**
   * Compile the given pattern by replacing all placeholders with values from the subject.
   *
   * @param string $pattern
   *   A string containing constants and model properties,
   *   separated by ".". Subject properties must be prefixed
   *   with "@" to be declared as such.
   *
   *   Example:
   *   The pattern "@id.@type.feature" compiles to "home.page.feature"
   *   if the subject's model has properties "id" and "type" which
   *   hold values "home" and "page".
   * @param \Tozart\Subject\SubjectBase $subject
   *   The subject.
   *
   * @return string
   *   A string.
   */
  protected function compilePattern($pattern, SubjectBase $subject) {
    $keys = array_filter(explode('.', $pattern), function ($key) {
      return substr($key, 0, 1) == '@';
    });

    $values = array_filter(array_map(function ($key) use ($subject) {
      return $subject->$key ?: '';
    }, $keys));

    if (count($values) === count($keys)) {
      $compiled_pattern = str_replace($keys, $values, $pattern);
      return $compiled_pattern;
    }
    return '';
  }

  /**
   * Find templates within the given dir that match one of the patterns.
   *
   * @param \Tozart\os\Directory $dir
   *   The directory.
   * @param array $patterns
   *   An array of string patterns.
   *
   * @return \Tozart\os\File[]
   *   An array of files each of which matches one of the filename patterns.
   */
  protected function match(Directory $dir, array $patterns) {
    // TODO: Match sub-directories as well.
    $templates = $dir->files();
    $matches = array_intersect(array_keys($templates), $patterns);
    return array_map(function ($path) use ($templates) {
      return $templates[$path];
    }, array_combine(array_keys($matches), $matches));
  }

}
