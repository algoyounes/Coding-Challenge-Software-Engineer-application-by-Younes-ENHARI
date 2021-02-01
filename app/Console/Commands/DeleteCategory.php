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
    protected $signature = 'command:DeleteCategory {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var ICategoryService
     */
    protected $categoryService;

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
     * @param ICategoryService $categoryService
     * @return int
     */
    public function handle(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $id = $this->argument('id');
        $res = $categoryService->delete($id);
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
