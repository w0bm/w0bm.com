<?php

use Illuminate\Database\Seeder;

class VideoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos = glob(public_path() . '/b/*');
        usort($videos, function($a, $b) {
            $a = (int) basename($a, '.webm');
            $b = (int) basename($b, '.webm');
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });

        $category = \App\Models\Category::where('shortname', '=', 'misc')->first();
        $user = \App\Models\User::first();

        foreach($videos as $video) {
            $v = new \App\Models\Video();
            $v->user()->associate($user);
            $v->category()->associate($category);
            $v->hash = sha1_file($video);
            $v->file = basename($video);
            $v->save();
        }
    }
}
