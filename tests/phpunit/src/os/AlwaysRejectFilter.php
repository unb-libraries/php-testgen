<?php

namespace Tozart\Test\os;

use Tozart\os\DirectoryFilterInterface;
use Tozart\os\File;

class AlwaysRejectFilter implements DirectoryFilterInterface {

  public function match(File $file) {
    return 0.0;
  }

}