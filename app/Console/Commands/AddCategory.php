<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ICategoryService;
use Illuminate\Database\Eloquent\Model;

class AddCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create {name} {parent_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new category';

    /**
     * @var ICategoryService
     */
    protected $categoryService;

    /**
     * Create a new command instance.
     */
    public function __construct(ICategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $parent_id = $this->argument('parent_id');

        if ($parent_id && !$this->categoryService->find($parent_id)) {
            $this->error('Parent is not exist!');
            return 1;
        }

        $category = $this->categoryService->create(['name' => $name, 'parent' => $parent_id]);

        if ($category) {
            $this->info("Category {$name} created successfully.");
            return 0;
        }

        $this->error("Something went wrong!");
        return 1;
    }

}
