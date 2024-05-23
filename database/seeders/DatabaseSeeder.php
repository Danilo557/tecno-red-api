<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'yolo',
            'email' => 'yolo@yolo.com',
            'password' => bcrypt('123456789')
        ]);

        User::factory(2)->create();
        
        Storage::deleteDirectory('public/storage/posts');
        Storage::makeDirectory('public/storage/posts');

        Client::factory(50)->create();
        $this->call(StatementSeeder::class);
        Brand::factory(10)->create();
        Store::factory(10)->create();
        Product::factory(100)->create();
        $this->call(InvoiceSeeder::class);
    }
}
