<?php

use App\Neck;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CreateNeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $neck = 
                [
                  [
                    'n_desc'=>'1',
                    'n_status'=>'1',
                  ],
                  [
                    'n_desc'=>'2',
                    'n_status'=>'1',
                  ],
                  [
                    'n_desc'=>'3',
                    'n_status'=>'1',
                  ],
                  [
                    'n_desc'=>'4',
                    'n_status'=>'1',
                  ],
                  [
                    'n_desc'=>'5',
                    'n_status'=>'1',
                  ],
                  [
                    'n_desc'=>'6',
                    'n_status'=>'1',
                  ],
                ];
        
        foreach ($neck as $key => $value) {
            Neck::create($value);
        }
    }
}
