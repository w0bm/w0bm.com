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
            'name' => 'Musicvideos',
            'shortname' => 'mv',
            'description' => 'WebMs containing music'
        ]);

        Category::create([
            'name' => 'Anime',
            'shortname' => 'anime',
            'description' => 'Everything from AMV to Hentai'
        ]);

        Category::create([
            'name' => 'Russia',
            'shortname' => 'russia',
            'description' => 'Сука Блять'
        ]);

        Category::create([
            'name' => 'Asians',
            'shortname' => 'asians',
            'description' => 'Mostly Korean and Japanese girls'
        ]);

        Category::create([
            'name' => 'Funny',
            'shortname' => 'funny',
            'description' => 'Supposed to be funny'
        ]);

        Category::create([
            'name' => 'Pr0n',
            'shortname' => 'pr0n',
            'description' => 'Crazy Japanese porn you will find my son'
        ]);

        Category::create([
            'name' => 'Politics',
            'shortname' => 'pol',
            'description' => 'Videos about faggots in suits'
        ]);

        Category::create([
            'name' => 'Misc',
            'shortname' => 'misc',
            'description' => 'Stuff that doesnt fit anywhere else'
        ]);
        
    }
}
