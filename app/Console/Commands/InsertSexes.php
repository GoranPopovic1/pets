<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sex;

class InsertSexes extends Command
{
    private $sexes;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:sexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with predefined sexes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->sexes = [
            'Muški',
            'Ženski',
            'Oba pola'
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->sexes as $sex) {
            Sex::create(
                [
                    'name' => $sex,
                ]
            );
        }
    }
}
