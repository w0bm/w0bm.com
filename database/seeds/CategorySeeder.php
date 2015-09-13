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
            'shortname' => 'musicvideo',
            'description' => 'Stuff which resembles a music video'
        ]);

        Category::create([
            'name' => 'Anime',
            'shortname' => 'anime',
            'description' => 'Animestuff'
        ]);

        Category::create([
            'name' => 'Russia',
            'shortname' => 'russia',
            'description' => 'Crazy russians dude'
        ]);

        Category::create([
            'name' => 'Japan',
            'shortname' => 'japan',
            'description' => 'Stuff from japan (not anime)'
        ]);

        Category::create([
            'name' => 'Funny',
            'shortname' => 'funny',
            'description' => 'Funny webms for your consideration'
        ]);

        Category::create([
            'name' => 'Pr0n',
            'shortname' => 'pr0n',
            'description' => 'Pretty grills and pr0n'
        ]);

        Category::create([
            'name' => 'News',
            'shortname' => 'news',
            'description' => 'News from around the world'
        ]);

        Category::create([
            'name' => 'Miscellaneous',
            'shortname' => 'misc',
            'description' => 'Stuff that doesnt fit anywhere else'
        ]);
    }
}
