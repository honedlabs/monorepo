<?php

namespace Workbench\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Workbench\App\Models\Category;
// use Workbench\App\Models\Category;
use Workbench\Database\Factories\CategoryFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carbon::setTestNow(Carbon::parse('1st January 2000'));        
        Category::factory(6)->create();
    }
}
