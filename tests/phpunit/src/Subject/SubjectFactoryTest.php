<?php

namespace Tozart\Test\Subject;

use Tozart\Model\ModelInterface;
use Tozart\Test\TozartTestCase;
use Tozart\Tozart;

class SubjectFactoryTest extends TozartTestCase {

  /**
   * The subject discovery.
   *
   * @var \Tozart\Discovery\DiscoveryInterface
   */
  protected $_subjectDiscovery;

  /**
   * Retrieve the subject factory.
   *
   * @return \Tozart\Subject\SubjectFactoryInterface
   *   A subject factory instance.
   */
  protected function getSubjectFactory() {
    return Tozart::subjectFactory();
  }

  /**
   * Retrieve the subject discovery.
   *
   * @return \Tozart\Discovery\SubjectDiscovery
   *   A subject discovery instance.
   */
  protected function subjectDiscovery() {
    if (!isset($this->_subjectDiscovery)) {
      $this->_subjectDiscovery = Tozart::subjectDiscovery();
      $this->_subjectDiscovery->stackSourceRoot($this->subjectRoot());
    }
    return $this->_subjectDiscovery;
  }

  /**
   * Retrieve the model manager.
   *
   * @return \Tozart\Model\ModelManagerInterface
   *   A model manager instance.
   */
  protected function modelManager() {
    return Tozart::modelManager();
  }

  /**
   * Test that a given type creates a model of the expected class.
   *
   * @param array $specification
   *   Subject specification array.
   *
   * @dataProvider subjectSpecificationProvider
   */
  public function testCreateSubject(array $specification) {
    $subject = $this->getSubjectFactory()->create($specification);
    $model = $this->modelManager()
      ->get($specification['type']);
    $this->assertInstanceOf($model->getSubjectClass(), $subject);
  }

  /**
   * Data provider for testCreateSubject().
   *
   * @return \Generator
   *   A generator which on each iteration will
   *   produce an array containing
   *   - subject specifications
   */
  public function subjectSpecificationProvider() {
    foreach ($this->subjectDiscovery()->discover() as $dir => $files) {
      foreach ($files as $filename => $file) {
        /** @var \Tozart\os\File $file */
        yield [$file->parse()];
      }
    }
  }

}
