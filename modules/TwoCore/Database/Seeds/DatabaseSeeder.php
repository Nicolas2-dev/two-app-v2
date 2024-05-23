<?php

namespace Modules\TwoCore\Database\Seeds;

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

        // $this->call('Modules\TwoCore\Database\Seeds\FoobarTableSeeder');
    }
}
