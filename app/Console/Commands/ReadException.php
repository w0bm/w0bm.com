<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReadException extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exception {file=php://stdin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrypts encrypted exception messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = $this->argument('file');
        $c = file_get_contents($input);
        if (false === $c) {
            $this->error('File not found');
            return;
        }
        //dd(explode(PHP_EOL, $c));
        list($iv, $c) = explode(PHP_EOL, $c);
        $iv = hex2bin($iv);
        $m = openssl_decrypt($c, 'aes128', env('APP_KEY'), 0, $iv);
        $this->line($m);
    }
}
