<?php

namespace App\Test;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class GenerateOrderSummaryTest extends KernelTestCase
{
  
  /** @test */
  public function generate_default_file_do_correctly()
  {    
    // SETUP
    $kernel = static::createKernel();
    $application = new Application($kernel);

    // Command
    $command = $application->find('app:GenerateOrderSummary');
    $commandTester = new CommandTester($command);

    // Do something
    $commandTester->execute([
      '--formatFile' => 'csv',
    ]);

    // success
    $output = $commandTester->getStatusCode();
    $this->assertEquals(Command::SUCCESS, $output);

  }

}
