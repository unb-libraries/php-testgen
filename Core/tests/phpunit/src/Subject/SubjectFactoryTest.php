<?php

namespace Trupal\Core\Test\Subject;

use Trupal\Core\Test\TrupalTestCase;
use Trupal\Core\Trupal;

class SubjectFactoryTest extends TrupalTestCase {

  /**
   * The subject discovery.
   *
   * @var \Trupal\Core\Discovery\DiscoveryInterface
   */
  protected $_subjectDiscovery;

  /**
   * Retrieve the subject factory.
   *
   * @return \Trupal\Core\Discovery\FactoryInterface
   *   A subject factory instance.
   */
  protected function getSubjectFactory() {
    return Trupal::subjectFactory();
  }

  /**
   * Retrieve the subject discovery.
   *
   * @return \Trupal\Core\Discovery\SubjectDiscovery
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
   * @return \Trupal\Core\Model\ModelManagerInterface
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
      /** @var \Trupal\Core\os\FileInterface $file */
      $specification = $file->parse();
      $model = $this->modelManager()
        ->get($specification['type']);
      yield [$specification['id'], $model->getSubjectClass()];
    }
  }

}
