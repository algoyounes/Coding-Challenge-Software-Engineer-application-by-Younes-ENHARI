<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use App\Services\ICategoryService;

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
     * @var ICategoryService
     */
    protected $categoryService;

    /**
     * Create a new command instance.
     *
     * @return void
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
    public function handle()
    {
        $id = $this->argument('id');
        $res = $this->categoryService->delete($id);
        if ($res === 0) {
            $this->error("Category with ID ".implode(', ', $id)." does not exist.");
            $this->info("deleted rows: {$res}");
            return 0;
        }
        $this->info("Category with ID ".implode(', ', $id)." has been deleted.");
        $this->info("deleted rows: {$res}");
        return 0;
    }
}
