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
  protected function execute(InputInterface $input, OutputInterface $output) {
    return self::SUCCESS;
  }

}
