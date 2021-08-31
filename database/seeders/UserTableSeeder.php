<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "An";
        $user->email = 'an@gmail.com';
        $user->password = '123456';
        $user->phone = '0984785142';
        $user->birth_date = 1999-05-29;
        $user->address = 'HN';
        $user->interest = 'Thich da bong';
        $user->save();
    }
}
