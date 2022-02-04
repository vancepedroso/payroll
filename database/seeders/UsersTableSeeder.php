<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users = [
        [
          'id'             => 1,
          'name'           => 'IT Admin',
          'email'          => 'thelaunchpadmanagement@gmail.com',
          'email_verified_at' => now(),
          'password'       => '$2y$10$pygjhF/991OlJDBlVoOUc.g37kkTyaQv8WAHkqEvQHRQ05FlRMFWq',//@L4unchp4d
          'remember_token' => null,
          'created_at'     => '2019-09-15 06:09:29',
          'updated_at'     => '2019-09-15 06:09:29',
        ],
      ];

      User::insert($users);
    }
}
