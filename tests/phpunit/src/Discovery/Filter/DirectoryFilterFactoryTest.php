<?php

namespace Tozart\Test\Discovery\Filter;

use PHPUnit\Framework\TestCase;
use Tozart\Discovery\Filter\DirectoryFilterFactory;

/**
 * Test the DirectoryFilterFactory class.
 *
 * @package Tozart\Test\Discovery\Filter
 */
class DirectoryFilterFactoryTest extends TestCase {

  /**
   * The filter factory to test.
   *
   * @var \Tozart\Discovery\Filter\DirectoryFilterFactoryInterface
   */
  protected $_factory;

  /**
   * Retrieve the filter factory to test.
   *
   * @return \Tozart\Discovery\Filter\DirectoryFilterFactoryInterface
   *   A directory filter factory object.
   */
  protected function factory() {
    return $this->_factory;
  }

  /**
   * Set up a factory with to test filters.
   */
  protected function setUp(): void {
    $this->_factory = new DirectoryFilterFactory([
      TestFilter::class,
      FakeFilter::class
    ]);
    parent::setUp();
  }

  /**
   * Test the "create" method.
   *
   * @param string $id
   *   The ID of filter.
   *
   * @dataProvider filterIdProvider
   */
  public function testCreate(string $id) {
    $filter = $this->factory()->create($id, []);
    if ($id !== $this->getInvalidId()) {
      $this->assertEquals($filter->getId(), $id);
    }
    else {
      // TODO: Test that failed attempt to create filter will be logged.
      $this->assertNull($filter);
    }
  }

  /**
   * Provide filter IDs.
   *
   * @return array
   *   An array of scenarios.
   */
  public function filterIdProvider() {
    return array_map(function ($filter_id) {
      return [$filter_id];
    }, array_merge($this->filterIds(), [$this->getInvalidId()]));
  }

  /**
   * Retrieve valid filter IDs.
   *
   * @return array
   *   An array of strings.
   */
  protected function filterIds() {
    return [
      TestFilter::getId(),
      FakeFilter::getId(),
    ];
  }

  /**
   * Fabricate an invalid filter ID.
   *
   * @return string
   *   A string.
   */
  protected function getInvalidId() {
    return implode('_', $this->filterIds());
  }

  /**
   * Test the "getSpecifications" method.
   */
  public function testGetSpecifications() {
    $specifications = $this->factory()->getSpecifications();
    $filter_ids = array_map(function ($specification) {
      if (array_key_exists('id', $specification)) {
        return $specification['id'];
      }
      return 'Undefined';
    }, $specifications);
    $this->assertEquals($this->filterIds(), array_values($filter_ids));
  }

}
