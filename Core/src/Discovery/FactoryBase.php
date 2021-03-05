<?php

namespace Trupal\Core\Discovery;

use Trupal\Core\Trupal;

/**
 * Base class for factory implementations.
 *
 * @package Trupal\Discovery
 */
abstract class FactoryBase implements FactoryInterface {

  /**
   * A discovery service instance.
   *
   * @var \Trupal\Discovery\DiscoveryInterface
   */
  protected $_discovery;

  /**
   * Retrieve the discovery service.
   *
   * @return \Trupal\Discovery\DiscoveryInterface
   *   A discovery object.
   */
  public function discovery() {
    return $this->_discovery;
  }

  /**
   * Construct a new ModelFactory instance.
   *
   * @param \Trupal\Discovery\DiscoveryInterface $discovery
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
  abstract protected function findSpecification($key);

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
