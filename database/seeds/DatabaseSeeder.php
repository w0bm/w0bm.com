<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //$this->call(CategorySeeder::class);
        //$this->call(VerifyUserSeeder::class);
        //$this->call(VideoTableSeeder::class);
        //$this->call(PermissionSeeder::class);
        //$this->call(RoleSeeder::class);
        $this->call(FilterSeeder::class);

        Model::reguard();
    }
}
