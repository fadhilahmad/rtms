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
                      'b_desc'=>'Adult',
                      'b_status'=>'1',
                  ],
                  [
                      'b_desc'=>'Kids',
                      'b_status'=>'1',
                  ],
                  [
                      'b_desc'=>'Muslimah',
                      'b_status'=>'1',
                  ],
                  [
                      'b_desc'=>'Rugby',
                      'b_status'=>'1',
                  ],
                ];
        
        foreach ($body as $key => $value) {
            Body::create($value);
        }
    }
}
