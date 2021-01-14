<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class AddCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AddCategory {name_Category} {id_parent?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Add New Category';

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
     * @return int
     */
    public function handle()
    {
        $category = new Category;
        $category->name = $this->argument('name_Category');

        $category_parent = $this->argument('id_parent');
        $category->parent()->associate($category_parent);

        $category->save();

    }
}
