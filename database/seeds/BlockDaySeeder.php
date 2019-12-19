<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\BlockDay;

class BlockDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $block =
                [
                  [
                      'day'=>'0',//sunday
                      'bd_status'=>'0',
                  ],
                  [
                      'day'=>'1',//monday
                      'bd_status'=>'0',
                  ],
                  [
                      'day'=>'2',//tuesday
                      'bd_status'=>'0',
                  ],
                  [
                      'day'=>'3',//wednesday
                      'bd_status'=>'0',
                  ],
                  [
                      'day'=>'4',//thursday
                      'bd_status'=>'0',
                  ],
                  [
                      'day'=>'5',//friday
                      'bd_status'=>'0',
                  ],
                  [
                      'day'=>'6',//saturday
                      'bd_status'=>'0',
                  ],
                ];
        
        foreach ($block as $key => $value) {
            BlockDay::create($value);
        }
    }
}
