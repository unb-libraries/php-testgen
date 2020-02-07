<?php

namespace TestGen\Test;

/**
 * Trait to test protected or private methods.
 *
 * @package TestGen\Test
 */
trait PrivateAccessTrait {

  /**
   * Execute a protected or private method of the given class.
   *
   * @param mixed $instance
   *   Name of the class that contains the method to test.
   * @param string $method_name
   *   Name of the method to test.
   * @param array $params
   *   Parameters the method requires.
   *
   * @return mixed
   *   Result of the method.
   */
  protected function getPrivateMethodResult($instance, $method_name, array $params = []) {
    try {
      $class = new \ReflectionClass(get_class($instance));
      $method = $class->getMethod($method_name);
      $method->setAccessible(TRUE);
      return $method->invoke($instance, $params);
    }
    catch (\ReflectionException $e) {
      return NULL;
    }
  }

}