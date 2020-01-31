<?php

namespace TestGen\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use TestGen\model\Model;
use TestGen\os\Directory;

class ModelTest extends TestCase {

  protected const MODEL_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models';

  /**
   * @return Directory
   */
  protected function modelRoot() {
    return new Directory(self::MODEL_ROOT);
  }

  /**
   * Test the creation of a model from a YAML file.
   */
  public function testCreateModelFromFile() {
    $model_file = $this->modelRoot()->files()[0];
    $model = Model::createFromFile($model_file);

    $yaml = Yaml::parse($model_file->content());

    $this->assertNotNull($model);
    $this->assertEquals($model->getId(), $yaml['id']);
    $this->assertEquals($model->getType(), $yaml['type']);
  }

}