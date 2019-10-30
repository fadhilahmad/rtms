<?php

use App\Body;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CreateBodySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $body =
                [
                  [
                      'b_desc'=>'ADULT',
                      'b_status'=>'1',
                  ],
                  [
                      'b_desc'=>'KIDS',
                      'b_status'=>'1',
                  ],
                  [
                      'b_desc'=>'MUSLIMAH',
                      'b_status'=>'1',
                  ],
                  [
                      'b_desc'=>'RUGBY',
                      'b_status'=>'1',
                  ],
                ];
        
        foreach ($body as $key => $value) {
            Body::create($value);
        }
    }
}
