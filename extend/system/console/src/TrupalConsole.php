<?php

namespace Trupal\Console;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Trupal\Core\Trupal;

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
   * @var \Trupal\Core\Trupal
   */
  protected $trupal;

  /**
   * Get the Trupal core application.
   *
   * @return \Trupal\Core\Trupal
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
  public function __construct($settings = []) {
    $settings = array_merge_recursive($this->defaultSettings(), $settings);
    parent::__construct($settings['name'], $settings['version']);
    $this->trupal = Trupal::instance();
    $this->initContainer();
    $this->initCommands();
  }

  protected function defaultSettings() {
    return [
      'name' => 'TRUPAL',
      'version' => 'DEV',
    ];
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

  /**
   * Find available console commands.
   *
   * @return array
   *   An array of TrupalConsole commands.
   *
   * @throws \Exception
   */
  public function findCommands() {
    $commands = [];
    $command_services = $this->container()
      ->findTaggedServiceIds($this->getCommandTagName());
    foreach ($command_services as $service_id => $tags) {
      $commands[] = $this->container()
        ->get($service_id);
    }
    return $commands;
  }

  /**
   * Get the tag name that identifies TrupalConsole commands.
   *
   * @return string
   *   A string.
   */
  public function getCommandTagName() {
    return self::COMMAND_TAG;
  }

}
