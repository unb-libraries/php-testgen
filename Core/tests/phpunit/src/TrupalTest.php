<?php

namespace Trupal\Core\Test;

use PHPUnit\Framework\TestCase;
use Trupal\Core\Discovery\FileSystemDiscovery;
use Trupal\Core\Discovery\Filter\DirectoryFilterFactory;
use Trupal\Core\Discovery\Filter\FileTypeFilter;
use Trupal\Core\Discovery\Filter\FileValidationFilter;
use Trupal\Core\Model\ModelFactory;
use Trupal\Core\Model\ModelManager;
use Trupal\Core\os\FileSystem;
use Trupal\Core\os\FileType;
use Trupal\Core\os\parse\FileParserManager;
use Trupal\Core\os\parse\YamlParser;
use Trupal\Core\render\RenderContextFactory;
use Trupal\Core\render\TemplateFinder;
use Trupal\Core\render\TwigRenderer;
use Trupal\Core\Subject\SubjectFactory;
use Trupal\Core\Subject\SubjectManager;
use Trupal\Core\Trupal;
use Trupal\Core\Validation\ModelValidator;
use Trupal\Core\Validation\SubjectValidator;
use Trupal\Core\Validation\ValidatorFactory;

/**
 * Test the Trupal class.
 *
 * @package Trupal\Core\Test
 */
class TrupalTest extends TestCase {

  protected $Trupal;

  protected function Trupal() {
    return $this->Trupal;
  }

  protected function setUp(): void {
    $this->Trupal = Trupal::instance();
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
    $service = $this->Trupal()->container()->get($service_id);
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
