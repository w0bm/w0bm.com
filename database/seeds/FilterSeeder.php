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
        $cats = \App\Models\Category::lists('id');

        foreach(\App\Models\User::withTrashed()->get() as $user) {
            $user->categories = $cats;
            $user->save();
        }
    }
}
