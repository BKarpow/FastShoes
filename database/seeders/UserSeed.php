<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin account
        if (!User::find(1)) {
            $user = new User();
            $user->name = 'Admin';
            $user->email = 'admin@fastshoes.shop';
            $user->password = Hash::make('123123123');
            $user->save();
        }
    }
}
