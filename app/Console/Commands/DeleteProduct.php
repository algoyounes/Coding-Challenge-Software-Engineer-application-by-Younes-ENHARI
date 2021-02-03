<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IProductService;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete
                            {id : The ID of the product to delete.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a specific product';

    /**
     * @var IProductService
     */
    protected $productService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');
        $res = $this->productService->delete($id);
        if ($res === 0) {
            $this->error("Product with ID ".implode(', ', $id)." does not exist.");
            $this->info("deleted rows: {$res}");
            return 0;
        }
        $this->info("Product(s) with ID ".implode(', ', $id)." has been deleted.");
        $this->info("deleted rows: {$res}");
        return 0;
    }
}
