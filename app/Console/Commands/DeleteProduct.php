<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;

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
     * @var ProductService
     */
    protected $productService;

    /**
     * Create a new command instance.
     * @param ProductService $productService
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $id = $this->argument('id');
        $res = $this->productService->delete($id);
        if (!$res) {
            $this->error("Product with ID ".$id." does not exist.");
            return;
        }
        $this->info("Product(s) with ID ".$id." has been deleted.");
    }
}
