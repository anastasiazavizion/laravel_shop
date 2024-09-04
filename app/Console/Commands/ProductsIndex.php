<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProductsIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Products index';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('scout:import', ['model' => "App\\Models\\Product"]);
    }
}
