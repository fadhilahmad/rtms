<?php

use App\DeliverySetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CreateDeliverySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //
       $delivery_setting=
       [
           [
               'min_day'=>'7',
           ],
       ];

        foreach ($delivery_setting as $key => $value) {
            DeliverySetting::create($value);
        }
    }
}
