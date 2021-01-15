<?php

namespace Trupal\Test\render;

use PHPUnit\Framework\TestCase;
use Trupal\Discovery\DiscoveryInterface;
use Trupal\os\DirectoryInterface;
use Trupal\os\FileInterface;
use Trupal\render\TemplateFinder;
use Trupal\Subject\SubjectInterface;

/**
 * Test the TemplateFinder class.
 *
 * @package Trupal\Test\render
 */
class TemplateFinderTest extends TestCase {

  /**
   * The template finder.
   *
   * @var \Trupal\render\TemplateFinderInterface
   */
  protected $_templateFinder;

  /**
   * Retrieve the template finder.
   *
   * @return \Trupal\render\TemplateFinderInterface
   *   A template finder object.
   */
  protected function templateFinder() {
    return $this->_templateFinder;
  }

  /**
   * {@inheritDoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->_templateFinder = new TemplateFinder($this->createTemplateDiscovery());
  }

  /**
   * Create a template discovery test double.
   *
   * @return \Trupal\Discovery\DiscoveryInterface
   *   An object pretending to be a discovery.
   */
  protected function createTemplateDiscovery() {
    $discovery = $this->createStub(DiscoveryInterface::class);
    $directories = [
      $this->createDirectory('/templates/samples/'),
      $this->createDirectory('/templates/examples/'),
    ];

    $discovery->method('directoryStack')
      ->willReturn($directories);
    $discovery->method('discover')
      ->willReturn([
        $this->createFile('m1.test', $directories[0]),
        $this->createFile('s1.m1.test', $directories[1]),
        $this->createFile('m2.test', $directories[1]),
      ]);
    return $discovery;
  }

  /**
   * Create a file double.
   *
   * @param string $name
   *   The name of the file.
   * @param \Trupal\os\DirectoryInterface $directory
   *   Directory which contains the file.
   *
   * @return \PHPUnit\Framework\MockObject\Stub
   *   An object pretending to be a file.
   */
  protected function createFile(string $name, DirectoryInterface $directory) {
    $file = $this->createStub(FileInterface::class);
    $file->method('name')
      ->willReturn($name);
    $file->method('directory')
      ->willReturn($directory);
    $file->method('path')
      ->willReturn($directory->systemPath() . $name);
    return $file;
  }

  /**
   * Create a directory double.
   *
   * @param string $path
   *   The path of the directory.
   *
   * @return \Trupal\os\DirectoryInterface
   *   An object pretending to be a directory.
   */
  protected function createDirectory(string $path) {
    $directory = $this->createStub(DirectoryInterface::class);
    $directory->method('systemPath')
      ->willReturn($path);
    return $directory;
  }

  /**
   * Test the findTemplate method.
   *
   * @param \Trupal\Subject\SubjectInterface $subject
   *   A subject for which to find a template.
   * @param string $expected_match
   *   The filename of the template file that is the expected match for the given subject.
   *
   * @dataProvider subjectProvider
   */
  public function testFindTemplate(SubjectInterface $subject, string $expected_match) {
    $template = $this->templateFinder()->findTemplate($subject);
    if ($expected_match) {
      $this->assertInstanceOf(FileInterface::class, $template);
      $this->assertEquals($expected_match, $template->path());
    }
    else {
      $this->assertFalse($template);
    }
  }

  /**
   * Provide subject instances and their expected match for testFindTemplate.
   *
   * @return array[]
   *   An array of arrays, each containing a subject and the template
   *   filename that is the expected match for the subject.
   */
  public function subjectProvider() {
    return [
      [$this->createSubject('s0', 'm1'), '/templates/samples/m1.test'],
      [$this->createSubject('s1', 'm1'), '/templates/examples/s1.m1.test'],
      [$this->createSubject('s2', 'm2'), '/templates/examples/m2.test'],
      [$this->createSubject('s3', 'm3'), ''],
    ];
  }

  /**
   * Create a subject test double.
   *
   * @param string $id
   *   A subject ID.
   * @param string $type
   *   A subject type.
   *
   * @return \Trupal\Subject\SubjectInterface
   *   An object pretending to be a subject.
   */
  protected function createSubject(string $id, string $type) {
    $subject = $this->createStub(SubjectInterface::class);
    $subject->method('getType')
      ->willReturn($type);
    $subject->method('getId')
      ->willReturn($id);

    // TODO: Test this with different patterns.
    $subject->method('getTemplateDiscoveryPatterns')
      ->willReturn([
        "^{$id}\.{$type}.*^",
        "^{$type}.*^",
      ]);

    return $subject;
  }

}
