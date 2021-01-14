<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Product;

class AddProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AddProduct {name} {description} {price} {Categoty_id} {path_image}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add New Product';

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

        $name        = $this->argument('name');
        $description = $this->argument('description');
        $price       = $this->argument('price');
        $Categoty_id = $this->argument('Categoty_id');
        $path_image  = $this->argument('path_image');

        $Product = New Product();

        $Product->name = $name;
        $Product->description = $description;
        $Product->price = $price;
        $Product->image = $path_image;

        $Product->save();

        $Product->categories()->attach($Categoty_id);

    }
}
