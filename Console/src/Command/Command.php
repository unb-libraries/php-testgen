<?php

namespace Trupal\Console\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Trupal\Core\TrupalInterface;

/**
 * Base class for TrupalConsole commands.
 *
 * @package Trupal\Console\Command
 */
abstract class Command extends SymfonyCommand {

  /**
   * The Trupal core.
   *
   * @var \Trupal\Core\TrupalInterface
   */
  protected $trupal;

  /**
   * Get the Trupal core.
   *
   * @return \Trupal\Core\TrupalInterface
   *   A Trupal object.
   */
  protected function trupal() {
    return $this->trupal;
  }

  /**
   * {@inheritDoc}
   */
  public static function getDefaultName() {
    return "trupal:" . parent::getDefaultName();
  }

  /**
   * GenerateTestsCommand constructor.
   *
   * @param \Trupal\Core\TrupalInterface $trupal
   *    The Trupal core.
   * @param string|null $name
   *    The command name.
   */
  public function __construct(TrupalInterface $trupal, $name = null) {
    parent::__construct($name);
    $this->trupal = $trupal;
  }

  /**
   * {@inheritDoc}
   */
  final protected function execute(InputInterface $input, OutputInterface $output) {
    try {
      $this->doExecute($input, $output);
      if (defined(self::class . '::SUCCESS')) {
        return self::SUCCESS;
      }
      return 0;
    }
    catch (\Exception $e) {
      if (defined(self::class . '::FAILURE')) {
        return self::FAILURE;
      }
      return 1;
    }
  }

  /**
   * Do the actual command execution.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Command line input.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Command line output.
   */
  abstract protected function doExecute(InputInterface $input, OutputInterface $output);
}
