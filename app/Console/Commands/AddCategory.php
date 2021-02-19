<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * Create a new command instance.
     * @param CategoryService $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();

        $this->categoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $parentId = (int) $this->argument('parent_id');

        try {
            $parent = $this->categoryService->find(20);
            if ($parent) {
                $newCategory = $this->categoryService->create(['name' => $name, 'parent_id' => $parentId])->toArray();
                $this->info("Category {$newCategory['name']} created successfully.");
            }
        } catch(ModelNotFoundException $e) {
            $this->error('Parent is not exist!');
        }
    }
}
