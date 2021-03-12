<?php

namespace Trupal\Core\Test;

/**
 * Trait to test protected or private methods.
 *
 * @package Trupal\Core\Test
 */
trait PrivateAccessTrait {

  /**
   * Execute a protected or private method of the given class.
   *
   * @param mixed $instance
   *   Name of the class that contains the method to test.
   * @param string $method_name
   *   Name of the method to test.
   * @param mixed $_
   *   Variable number of parameters to be passed to the method to test.
   *
   * @return mixed
   *   Result of the method.
   */
  protected function getPrivateMethodResult($instance, $method_name, $_ = NULL) {
    try {
      $class = new \ReflectionClass(get_class($instance));
      $method = $class->getMethod($method_name);
      $method->setAccessible(TRUE);
      return $method->invoke($instance, $_);
    }
    catch (\ReflectionException $e) {
      return NULL;
    }
  }

}
