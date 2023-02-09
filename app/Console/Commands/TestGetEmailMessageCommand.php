<?php

namespace App\Console\Commands;

use App\Service\MailAnalysis;
use Illuminate\Console\Command;

class TestGetEmailMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = __DIR__."/../../../tests/Feature/sample.txt";
        $fp = fopen($filename, 'r');
        $txt = "";
        while (!feof($fp)) {
            $txt .= str_replace("\n", "\r\n", fgets($fp));
        }
        dump(MailAnalysis::regex(1675852326, $txt));
        fclose($fp);
    }
}
