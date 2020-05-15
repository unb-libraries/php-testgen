<?php

namespace Tozart\Test\os;

use Tozart\os\DirectoryFilterInterface;
use Tozart\os\File;

class RandomPassFilter implements DirectoryFilterInterface {

  public function match(File $file) {
    return max(0.01, mt_rand() / mt_getrandmax());
  }

}