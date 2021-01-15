<?php

namespace Trupal\render;

use Trupal\Subject\SubjectInterface;

/**
 * Factory for creating render context instances.
 *
 * @package Trupal\render
 */
class RenderContextFactory implements RenderContextFactoryInterface {

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
   * Create a new RenderContextFactory instance.
   *
   * @param \Trupal\render\TemplateFinderInterface $template_finder
   *   A template finder object.
   */
  public function __construct(TemplateFinderInterface $template_finder) {
    $this->_templateFinder = $template_finder;
  }

  /**
   * {@inheritDoc}
   */
  public function create(SubjectInterface $subject) {
    if ($template = $this->templateFinder()->findTemplate($subject)) {
      return new RenderContext($subject->getProperties(), $template);
    }
    return FALSE;
  }

}
