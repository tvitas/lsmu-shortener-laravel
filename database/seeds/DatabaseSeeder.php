<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // factory('App\User', 4)->create();
        DB::table('users')
            ->updateOrInsert(
                [
                    'email' => 'root',
                ],
                [
                    'name' => 'Root Administrator',
                    'email' => 'root',
                    'password' => Hash::make('baik2bajerius'), 'role' => 'root',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    }
}
