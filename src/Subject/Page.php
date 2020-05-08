<?php

namespace Tozart\Subject;

class Page extends SubjectBase {

  protected $url;

  public function getType() {
    return 'page';
  }

  public function getUrl() {
    return $this->url;
  }

  public function setUrl($url) {
    $this->url = $url;
  }



}