<?php

namespace Modules\TwoThemes\Database\Seeds;

use Two\Database\ORM\Model;
use Two\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    /**
     * Exécutez les graines de base de données.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('Modules\TwoThemes\Database\Seeds\FoobarTableSeeder');
    }
}
