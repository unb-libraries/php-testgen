<?php

namespace Tozart\render;

use Tozart\Discovery\DiscoveryInterface;
use Tozart\os\File;
use Tozart\Subject\SubjectInterface;

/**
 * Base class for printer implementations.
 *
 * @package Tozart\render
 */
abstract class Printer implements RendererInterface {

  /**
   * The template discovery.
   *
   * @var \Tozart\Discovery\DiscoveryInterface
   */
  protected $_templateDiscovery;

  /**
   * @return mixed
   */
  protected function templateDiscovery() {
    return $this->_templateDiscovery;
  }

  /**
   * Create a new printer instance.
   *
   * @param \Tozart\Discovery\DiscoveryInterface $template_discovery
   *   The template discovery.
   */
  public function __construct(DiscoveryInterface $template_discovery) {
    $this->_templateDiscovery = $template_discovery;

  }

  /**
   * Initialize the renderer.
   */
  protected function init() {
  }

  /**
   * {@inheritDoc}
   */
  public function render($subject) {
    if ($template = $this->getTemplate($subject)) {
      $context = $this->getContext($subject);
      return $this->doRender($template, $context);
    }
    return '';
  }

  /**
   * Render the given template with the given context.
   *
   * @param \Tozart\os\File $template
   *   The template.
   * @param array $context
   *   An array containing variables to be used in
   *   the template.
   *
   * @return string
   *   The rendered content.
   */
  abstract protected function doRender(File $template, array $context);

  /**
   * Retrieve a template for the given subject.
   *
   * @param \Tozart\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return \Tozart\os\File|false
   *   A file. False if no file could be found that
   *   matches the criteria.
   */
  protected function getTemplate(SubjectInterface $subject) {
    return $this->templateDiscovery()->findBy($subject);
  }

  /**
   * Retrieve a render context, i.e. variables to use in a template.
   *
   * @param \Tozart\Subject\SubjectInterface $subject
   *   The subject.
   *
   * @return array
   *   An array of the form VARIABLE => VALUE.
   */
  protected function getContext(SubjectInterface $subject) {
    return $subject->getProperties();
  }

}
