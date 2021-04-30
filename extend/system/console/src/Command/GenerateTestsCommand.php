<?php

namespace Trupal\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to render subjects into executable test cases.
 *
 * The command requires two arguments:
 * - source: the folder where subjects are supposedly located.
 * - output: the folder to which to write generated test cases.
 *
 * @example
 * trupal trupal:generate ../tests/trupal ../tests/behat/features
 *
 * @package Trupal\Console\Command
 */
class GenerateTestsCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected static $defaultName = 'generate';

  /**
   * {@inheritDoc}
   */
  protected function doExecute(InputInterface $input, OutputInterface $output) {
    $subject_root = $input->getArgument('source');
    $output_dir = $input->getArgument('output');
    $tests = $tests = $this->trupal()->generate($subject_root, $output_dir);

    if (!empty($tests)) {
      foreach ($tests as $filename) {
        $output->writeln($filename);
      }
    }
    else {
      $output->writeln('No subjects generated.');
    }
  }

  /**
   * {@inheritDoc}
   */
  protected function configure() {
    parent::configure();
    $this
      ->setDescription('Generates test cases from subject definitions located in the <source> folder into the <output> folder.');
    $this
      ->addArgument('source', InputArgument::REQUIRED, 'The folder in which to expect subjects.')
      ->addArgument('output', InputArgument::REQUIRED, 'The folder to which to write generated tests.');
  }

}
