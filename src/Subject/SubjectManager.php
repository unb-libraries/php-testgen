<?php

namespace Tozart\Subject;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Tozart\os\Directory;

class SubjectManager {

  protected $_subjects;

  protected $_subjectRoots = [];

  protected $_factory;

  public function subjects() {
    if (!$this->_subjects) {
      $this->_subjects = [];
      $this->discover();
    }
    return $this->_subjects;
  }

  /**
   * A collection of directories in which to search for subjects.
   *
   * @return \Tozart\os\Directory[]
   *   A collection of directory objects.
   */
  public function subjectRoots() {
    return $this->_subjectRoots;
  }

  protected function factory() {
    return $this->_factory;
  }

  public function __construct(SubjectFactory $factory, array $subject_roots = []) {
    $this->_factory = $factory;
    foreach ($subject_roots as $subject_root) {
      $this->addSubjectRoot($subject_root);
    }
  }

  /**
   * Add a subject root.
   *
   * @param \Tozart\os\Directory|string $subject_root
   *   A directory object or a string.
   */
  public function addSubjectRoot($subject_root) {
    if (is_string($subject_root)) {
      $subject_root = new Directory($subject_root);
    }
    $this->_subjectRoots[$subject_root->systemPath()] = $subject_root;
  }

  public function addSubject(SubjectBase $subject) {
    $$this->_subjects[$subject->getId()] = $subject;
  }

  public function discover() {
    foreach ($this->subjectRoots() as $path => $dir) {
      foreach ($dir->files() as $file) {
        if ($subject = $this->factory()->createFromFile($file)) {
          $this->addSubject($subject);
        }
      }
    }
  }

  public function get($subject_id) {
    if (array_key_exists($subject_id, $this->subjects())) {
      return $this->subjects()[$subject_id];
    }
    return NULL;
  }

}
