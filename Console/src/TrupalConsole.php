<?php

namespace Trupal\Console;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Trupal\Trupal;

/**
 * The TrupalConsole main class.
 *
 * @package Trupal\Console
 */
class TrupalConsole extends Application {

  const COMMAND_TAG = 'console.command.trupal';

  /**
   * The Trupal core application.
   *
   * @var \Trupal\Trupal
   */
  protected $trupal;

  /**
   * Get the Trupal core application.
   *
   * @return \Trupal\Trupal
   *   A Trupal instance.
   */
  protected function trupal() {
    return $this->trupal;
  }

  /**
   * Gets the service container.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerBuilder
   *   A service container.
   */
  protected function container() {
    return $this->trupal()
      ->container();
  }

  /**
   * TrupalConsole constructor.
   *
   * @throws \Exception
   */
  public function __construct() {
    parent::__construct('TRUPAL', 'DEV');
    $this->trupal = Trupal::instance();
    $this->initContainer();
  }

  /**
   * Initialize the service container with additional services.
   *
   * @throws \Exception
   */
  protected function initContainer() {
    $locator = new FileLocator([$this->configDir()]);
    $loader = new YamlFileLoader($this->container(), $locator);
    $loader->load('services.yml');
  }

  /**
   * Get the paths to the config directory.
   *
   * @return string
   *   A string.
   */
  protected function configDir() {
    $path = __DIR__ . '/../config';
    $sep = DIRECTORY_SEPARATOR;
    return str_replace('/', $sep, $path);
  }

  /**
   * Initialize the application commands.
   */
  protected function initCommands() {
    $this->addCommands($this->findCommands());
  }

