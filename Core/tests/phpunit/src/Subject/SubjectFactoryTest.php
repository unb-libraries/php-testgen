<?php

namespace Trupal\Test\Subject;

use Trupal\Test\TrupalTestCase;
use Trupal\Trupal;

class SubjectFactoryTest extends TrupalTestCase {

  /**
   * The subject discovery.
   *
   * @var \Trupal\Discovery\DiscoveryInterface
   */
  protected $_subjectDiscovery;

  /**
   * Retrieve the subject factory.
   *
   * @return \Trupal\Discovery\FactoryInterface
   *   A subject factory instance.
   */
  protected function getSubjectFactory() {
    return Trupal::subjectFactory();
  }

  /**
   * Retrieve the subject discovery.
   *
   * @return \Trupal\Discovery\SubjectDiscovery
   *   A subject discovery instance.
   */
  protected function subjectDiscovery() {
    if (!isset($this->_subjectDiscovery)) {
      $this->_subjectDiscovery = Trupal::subjectDiscovery();
      $this->_subjectDiscovery->addDirectory($this->subjectRoot());
    }
    return $this->_subjectDiscovery;
  }

  /**
   * Retrieve the model manager.
   *
   * @return \Trupal\Model\ModelManagerInterface
   *   A model manager instance.
   */
  protected function modelManager() {
    return Trupal::modelManager();
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
      /** @var \Trupal\os\FileInterface $file */
      $specification = $file->parse();
      $model = $this->modelManager()
        ->get($specification['type']);
      yield [$specification['id'], $model->getSubjectClass()];
    }
  }

}
