<?php

namespace Tozart\Discovery\Filter;

use Tozart\os\File;

interface DirectoryFilterInterface {

  public function match(File $file);

}
