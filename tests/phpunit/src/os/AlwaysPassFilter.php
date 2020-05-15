<?php

namespace Tozart\Test\os;


use Tozart\os\DirectoryFilterInterface;
use Tozart\os\File;

class AlwaysPassFilter implements DirectoryFilterInterface {

  public function match(File $file) {
    return 1.0;
  }

}