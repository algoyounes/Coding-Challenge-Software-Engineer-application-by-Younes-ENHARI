<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;

class AddProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create
                            {--name= : The name of the product Ex: IPhone 11 pro}
                            {--description= : The description of the product}
                            {--price= : The price of the product}
                            {--category_id= : The category ID of the product}
                            {--image= : The image absolute path of the product image Ex: /home/sammy/images/iphone.png }';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add New Product';

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
    public function handle() : void
    {
        $data = collect($this->options())->only(['name', 'description', 'price', 'category_id', 'image'])->all();

        if (!$this->productService->validate($data)) {
            $this->error('Some fields are not fielded correctly !');
            return;
        }

        $upload_path = $this->productService->uploadImageCLI(trim($data['image']));
        if (!$upload_path) {
            $this->error('Cannot move the image to upload folder.');
            return;
        }

        $data['image'] = $upload_path;
        $res = $this->productService->create($data)->toArray();
        $this->info("Product {$res['name']} created successfully.");
    }
}
