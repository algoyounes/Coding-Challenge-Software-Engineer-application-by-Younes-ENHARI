<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CategoryService;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a specific category';

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
    public function handle() : void
    {
        $id = $this->argument('id');
        $res = $this->categoryService->delete($id);
        if (!$res) {
            $this->error("Category with ID ".$id." doesn't exist.");
            return;
        }
        $this->info("Category with ID ".$id." has been deleted.");
    }
}
