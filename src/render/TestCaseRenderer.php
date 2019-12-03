<?php

namespace TestGen\render;

use TestGen\model\TestModel;

class TestCaseRenderer {

  public function render(TestModel $model) {
    $template = $this->loadTemplate($model->getType());
    // TODO: Replace template placeholders with values from the model, e.g. input/output expectations.
    return $template;
  }

  public function loadTemplate($model_type) {
    // TODO: load a template file base on the given model type and return its contents.
    return '';
  }

}