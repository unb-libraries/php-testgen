<?php

namespace Tozart\Test\Subject;

use PHPUnit\Framework\TestCase;
use Tozart\Subject\SubjectModel;
use Tozart\os\Directory;
use Tozart\os\YamlFile;

class SubjectModelTest extends TestCase {

  const MODEL_DEFINITION_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models';

  public function testModelClass() {
    $model = new SubjectModel('example', ExampleSubject::class);
    $this->assertEquals(ExampleSubject::class, $model->getModelClass());
  }

  public function testCreateFromFile() {
    $yaml = new YamlFile('example.yml', new Directory(self::MODEL_DEFINITION_DIR));
    $model = SubjectModel::createFromFile($yaml);
    $this->assertInstanceOf(SubjectModel::class, $model);
  }

}