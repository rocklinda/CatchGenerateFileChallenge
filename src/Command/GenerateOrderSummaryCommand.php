<?php

namespace App\Command;

use App\Utility\FormatFileEnum;
use App\Service\GenerateOrderSummaryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateOrderSummaryCommand extends Command
{
    protected static $defaultName = 'GenerateOrderSummary';
    protected static $defaultDescription = 'Generate Order Summary File in csv, jsonl, or xml';

    /**
     * @var GenerateOrderSummaryService
     */
    private GenerateOrderSummaryService $generateOrderSummary;

    
    public function __construct(GenerateOrderSummaryService $generateOrderSummary)
    {
        $this->generateOrderSummary = $generateOrderSummary;

        parent::__construct();
    }


    protected function configure(): void
    {        
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('formatFile', null, InputArgument::OPTIONAL, 'Input format in csv, jsonl, or xml')
            ->addOption('email', null, InputArgument::OPTIONAL, 'Generated file will send to an email', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $formatFile = $input->getOption('formatFile') ?? FormatFileEnum::$CSV; // to do check valid format file
        $sendEmail = $input->getOption('email') ?? null;

        $io->title('Start to generate your order summary file');
        $io->note('Your output file is in ' . $formatFile );
        if(!empty($sendEmail)){ $io->note('Your file will send to ' . $sendEmail); }
        
        try {
            $this->generateOrderSummary->generate($formatFile, $sendEmail);
            $io->success('Your order summary was generated!');
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
