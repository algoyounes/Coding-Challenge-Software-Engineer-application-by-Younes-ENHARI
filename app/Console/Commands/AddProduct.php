<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IProductService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
                            {--photo= : The image absolute path of the product image Ex: /home/sammy/images/iphone.png }';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add New Product';

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
        $data = collect($this->options())->only(['name', 'description', 'price', 'category_id', 'image'])->all();

        if (!$this->validate($data)) {
            return 1;
        }

        $productService->create($data);

        $this->info("Product {$data['name']} created successfully.");
        return 0;
    }

    public function validate($product): bool
    {
        $imageError = null;

        $validator = Validator::make($product, [
            'name' => ['required', 'max:255'],
            'description' => ['max:255'],
            'price' => ['required', 'numeric', 'between:0,999999.99'],
            'category_id' => ['required', 'numeric', 'exists:App\Category,id'],
        ]);

        /**
         * validate if the provided file --image is a valid image.
         */
        if ($product['image']) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            if (File::exists(trim($product['image']))) {
                $contentType = File::mimeType(trim($product['image']));
                if(!in_array($contentType, $allowedMimeTypes, false)){
                    $imageError = 'The file provided as an image is not a valid image';
                } else {
                    $imageError = 'The file provided is not exist';
                }
            }

        }


        if ($validator->fails()) {
            $this->info('Product not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            if ($imageError) {
                $this->error($imageError);
            }
            return false;
        }
        return true;
    }


}
