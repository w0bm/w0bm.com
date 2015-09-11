<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Music Videos',
            'description' => 'Stuff which resembles a music video'
        ]);

        Category::create([
            'name' => 'Anime',
            'description' => 'Animestuff'
        ]);

        Category::create([
            'name' => 'Misc',
            'description' => 'Stuff that doesnt fit anywhere else'
        ]);
    }
}
