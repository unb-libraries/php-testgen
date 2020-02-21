<?php

namespace TestGen\model;

class PageModel extends Model {

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