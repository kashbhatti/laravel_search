<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Importing Products');

        $products = DB::connection('legacy')->table('oc_product')
            ->join('oc_product_description', 'oc_product_description.product_id', '=', 'oc_product.product_id')
            ->selectRaw('oc_product.product_id, replace(oc_product.image, "catalog/products/", "") as image, oc_product_description.name, IFNULL(oc_product_description.description, oc_product_description.name) as description, oc_product.price')
            ->get();

        $progressBar = $this->output->CreateProgressBar(count($products));

        foreach ($products as $product) {
            try {
                DB::beginTransaction();

                $newProduct = new Product;
                $newProduct->name = $product->name;
                $newProduct->description = $product->description;
                $newProduct->price = $product->price;
                $newProduct->image = $product->image;
                $newProduct->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();

                $this->error($e->getMessage());
            }
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->info("\r");
        $this->info('Products import complete');
    }
}
