<?php

namespace Trupal\Console\Command;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base class for TrupalConsole commands.
 *
 * @package Trupal\Console\Command
 */
abstract class Command extends SymfonyCommand {

  /**
   * {@inheritDoc}
   */
  public static function getDefaultName() {
    return "trupal:" . parent::getDefaultName();
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
