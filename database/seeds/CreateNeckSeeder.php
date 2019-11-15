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
                    'n_desc'=>'Round Neck',
                    'n_type'=>'2',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116012550.jpeg',
                  ],
                  [
                    'n_desc'=>'2 Piece Round Neck',
                    'n_type'=>'2',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116012628.jpeg',
                  ],
                  [
                    'n_desc'=>'V Neck',
                    'n_type'=>'2',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116012701.jpeg',
                  ],
                  [
                    'n_desc'=>'2 Piece V-Neck',
                    'n_type'=>'2',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116012739.jpeg',
                  ],
                  [
                    'n_desc'=>'Polo',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116012927.jpeg',
                  ],
                  [
                    'n_desc'=>'Polo Collor Hidden Button',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116013009.jpeg',
                  ],
                  [
                    'n_desc'=>'Mandarin Collar Button',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116013045.jpeg',
                  ],
                  [
                    'n_desc'=>'Mandarin Collar Hidden Button',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116013155.jpeg',
                  ],
                  [
                    'n_desc'=>'Mandarin Collar Zip 5 Inch',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116013247.jpeg',
                  ],
                  [
                    'n_desc'=>'Polo V-Neck',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116013411.jpeg',
                  ],
                  [
                    'n_desc'=>'Polo RoundNeck',
                    'n_type'=>'1',
                    'n_status'=>'1',
                    'n_url'=>'necktype20191116013442.jpeg',
                  ],
                ];
        
        foreach ($neck as $key => $value) {
            Neck::create($value);
        }
    }
}
