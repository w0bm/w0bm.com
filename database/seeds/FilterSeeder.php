<?php

use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = \App\Models\Category::all(['id']);
        foreach(\App\Models\User::all() as $user) {
            $user->categories()->sync($categories);
        }
    }
}
