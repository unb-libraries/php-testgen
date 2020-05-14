<?php

namespace Tozart\Test\Subject;

use Tozart\Subject\SubjectBase;

class ExampleSubject extends SubjectBase {

  protected $property1;
  protected $property2;
  protected $option1;

  public function getType() {
    return 'example';
  }

}
