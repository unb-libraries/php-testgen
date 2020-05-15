<?php

namespace Tozart\os;

use Tozart\os\File;

interface DirectoryFilterInterface {

  public function match(File $file);

}
