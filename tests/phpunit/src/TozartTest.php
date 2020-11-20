<?php

namespace Tozart\Test;

use PHPUnit\Framework\TestCase;
use Tozart\Discovery\FileSystemDiscovery;
use Tozart\Discovery\Filter\DirectoryFilterFactory;
use Tozart\Discovery\Filter\FileTypeFilter;
use Tozart\Discovery\Filter\FileValidationFilter;
use Tozart\Model\ModelFactory;
use Tozart\Model\ModelManager;
use Tozart\os\FileSystem;
use Tozart\os\FileType;
use Tozart\os\parse\FileParserManager;
use Tozart\os\parse\YamlParser;
use Tozart\render\RenderContextFactory;
use Tozart\render\TemplateFinder;
use Tozart\render\TwigRenderer;
use Tozart\Subject\SubjectFactory;
use Tozart\Subject\SubjectManager;
use Tozart\Tozart;
use Tozart\Validation\ModelValidator;
use Tozart\Validation\SubjectValidator;
use Tozart\Validation\ValidatorFactory;

/**
 * Test the Tozart class.
 *
 * @package Tozart\Test
 */
class TozartTest extends TestCase {

  protected $tozart;

  protected function tozart() {
    return $this->tozart;
  }

  protected function setUp(): void {
    $this->tozart = Tozart::instance();
    parent::setUp();
  }

  /**
   * Test that a service with the given ID exist and yields an object of the expected type.
   *
   * @param string $service_id
   *   The service identifier.
   * @param string $expected_interface
   *   The type of which the instantiated service is expected to be.
   *
   * @dataProvider serviceProvider
   */
  public function testCreateService(string $service_id, string $expected_interface) {
    $service = $this->tozart()->container()->get($service_id);
    $this->assertInstanceOf($expected_interface, $service);
  }

  /**
   * Data provider for testCreateService.
   *
   * @return array
   *   An array of service IDs and their expected types.
   */
  public function serviceProvider() {
    return [
      ['file_system.file_type.yaml', FileType::class],
      ['file_system.file_type.twig', FileType::class],
      ['file_system.parse.yaml', YamlParser::class],
      ['file_system.parse.manager', FileParserManager::class],
      ['file_system', FileSystem::class],
      ['validator.factory', ValidatorFactory::class],
      ['validator.model', ModelValidator::class],
      ['validator.subject', SubjectValidator::class],
      ['directory_filter.factory', DirectoryFilterFactory::class],
      ['directory_filter.filetype.yaml', FileTypeFilter::class],
      ['directory_filter.filetype.twig', FileTypeFilter::class],
      ['directory_filter.model', FileValidationFilter::class],
      ['directory_filter.subject', FileValidationFilter::class],
      ['model.discovery', FileSystemDiscovery::class],
      ['model.factory', ModelFactory::class],
      ['model.manager', ModelManager::class],
      ['subject.discovery', FileSystemDiscovery::class],
      ['subject.factory', SubjectFactory::class],
      ['subject.manager', SubjectManager::class],
      ['render.template_discovery', FileSystemDiscovery::class],
      ['render.template_finder', TemplateFinder::class],
      ['render.context_factory', RenderContextFactory::class],
      ['render.renderer', TwigRenderer::class],
    ];
  }

}
