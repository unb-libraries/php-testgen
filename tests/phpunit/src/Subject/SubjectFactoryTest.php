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
   * @return \Tozart\Discovery\FactoryInterface
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
      $this->_subjectDiscovery->addDirectory($this->subjectRoot());
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
   * @param string $id
   *   The subject ID.
   * @param string $expected_class
   *   The expected class name.
   *
   * @dataProvider subjectSpecificationProvider
   */
  public function testCreateSubject($id, $expected_class) {
    $subject = $this->getSubjectFactory()->create($id);
    $this->assertInstanceOf($expected_class, $subject);
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
    // TODO: For some reasons, two instances of subject discovery are created (one discovers subjects, the other one does not).
    foreach ($this->subjectDiscovery()->discover() as $filename => $file) {
      /** @var \Tozart\os\File $file */
      $specification = $file->parse();
      $model = $this->modelManager()
        ->get($specification['type']);
      yield [$specification['id'], $model->getSubjectClass()];
    }
  }

}
