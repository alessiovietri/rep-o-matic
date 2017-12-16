<?php

use Illuminate\Database\Seeder;

use App\Models\ENTITYNAME as ENTITYNAME;

class ENTITYNAMEsSeeder extends Seeder
{
    public function run()
    {
        // Empty the ENTITYNAME table before filling it
        ENTITYNAME::where('id', '<>', null)->delete();
    }
}
