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
                        'sl_desc'=>'LONG',
                        'sl_status'=>'1',
                    ],
                    [
                        'sl_desc'=>'SHORT',
                        'sl_status'=>'1',
                    ],
                    [
                        'sl_desc'=>'SINGLET',
                        'sl_status'=>'1',
                    ],
                ];
        
        foreach ($sleeve as $key => $value) {
            Sleeve::create($value);
        }
    }
}
