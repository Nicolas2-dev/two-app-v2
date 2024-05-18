<?php
/**
 * Two - UsersTableSeeder
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Database\Seeds;

use Two\Database\Seeder;
use Two\Support\Facades\Hash;
use Two\Support\Str;

use App\Models\User;


class UsersTableSeeder extends Seeder
{

    /**
     * Exécutez les graines de la base de données.
     *
     * @return void
     */
    public function run()
    {
        // Tronquez le tableau avant de semer.
        User::truncate();

        User::create(array(
            'id'             => 1,
            'username'       => 'admin',
            'password'       => Hash::make('admin'),
            'realname'       => 'Site Administrator',
            'email'          => 'admin@Two.dev',
            'remember_token' => '',
            'api_token'      => Str::random(60),
        ));
    }
}
