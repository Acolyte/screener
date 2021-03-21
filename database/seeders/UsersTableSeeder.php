<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users() as $userData) {
            $user = new User($userData);
            $user->markEmailAsVerified();
            $user->saveOrFail();
        }
    }

    public function users()
    {
        return [
            ['name' => 'Daniel Protopopov', 'email' => 'coytes@mail.ru', 'password' => Hash::make('magicrpg11')]
        ];
    }
}
