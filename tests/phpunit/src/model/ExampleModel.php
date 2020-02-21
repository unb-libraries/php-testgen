<?php

namespace TestGen\Test\model;

use TestGen\model\Model;

class ExampleModel extends Model {

  protected $property1;
  protected $property2;
  protected $option1;

  public function getType() {
    return 'example';
  }

}
