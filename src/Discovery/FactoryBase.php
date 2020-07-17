<?php

namespace Tozart\Discovery;

/**
 * Base class for factory implementations.
 *
 * @package Tozart\Discovery
 */
abstract class FactoryBase implements FactoryInterface {

  /**
   * A discovery service instance.
   *
   * @var \Tozart\Discovery\DiscoveryInterface
   */
  protected $_discovery;

  /**
   * Retrieve the discovery service.
   *
   * @return \Tozart\Discovery\DiscoveryInterface
   *   A discovery object.
   */
  public function discovery() {
    return $this->_discovery;
  }

  /**
   * Construct a new ModelFactory instance.
   *
   * @param \Tozart\Discovery\DiscoveryInterface $discovery
   *   A discovery service instance.
   */
  public function __construct(DiscoveryInterface $discovery) {
    $this->_discovery = $discovery;
  }

  /**
   * {@inheritDoc}
   */
  public function create($key) {
    if ($specification = $this->findSpecification($key)) {
      return $this->doCreate($specification);
    }
    return FALSE;
  }

  /**
   * Find a model specification for the given type.
   *
   * @param string $key
   *   A string.
   *
   * @return array|false
   *   A specification array. FALSE if no specification
   *   exists for the given type.
   */
  protected function findSpecification($key) {
    if ($specification = $this->discovery()->findBy($key)) {
      return $specification;
    }
    return FALSE;
  }

  /**
   * Actually build the resource from the given specification.
   *
   * @param mixed $specification
   *   Specifications.
   *
   * @return mixed
   *   An object.
   */
  abstract protected function doCreate($specification);

}
