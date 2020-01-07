<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;

class InsertCategories extends Command
{
    private $categories;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with predefined categories.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->categories = [
            'Psi',
            'Mačke',
            'Ptice',
            'Konji',
            'Ribice',
            'Glodari',
            'Reptili i amfibije',
            'Ostalo'
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->categories as $category) {
            Category::create(
                [
                    'name' => $category,
                ]
            );
        }
    }
}
