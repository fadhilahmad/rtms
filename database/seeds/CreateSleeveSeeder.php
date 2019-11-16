<?php

use App\Sleeve;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CreateSleeveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sleeve=
                [
                    [
                        'sl_desc'=>'Long Sleeve',
                        'sl_status'=>'1',
                    ],
                    [
                        'sl_desc'=>'Short Sleeve',
                        'sl_status'=>'1',
                    ],
                    [
                        'sl_desc'=>'Singlet',
                        'sl_status'=>'1',
                    ],
                ];
        
        foreach ($sleeve as $key => $value) {
            Sleeve::create($value);
        }
    }
}
