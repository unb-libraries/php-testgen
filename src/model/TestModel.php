<?php

namespace TestGen\model;

class TestModel {

  const STATUS_ENABLED = 'enabled';
  const STATUS_DISABLED = 'disabled';

  protected $id;
  protected $type;
  protected $status;

  public function getId() {
    return $this->id;
  }

  public function getType() {
    return $this->type;
  }

  public function __construct($id, $type, $status = self::STATUS_ENABLED) {
    $this->id = $id;
    $this->type = $type;
    $this->status = $status;
  }



}
