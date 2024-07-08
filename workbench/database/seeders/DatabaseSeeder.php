<?php

namespace Workbench\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Workbench\Database\Factories\ProductFactory;
use Workbench\Database\Factories\CategoryFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carbon::setTestNow(Carbon::parse('1st January 2000'));
        
        CategoryFactory::new()
            ->count(6)
            ->create();
    }
}
