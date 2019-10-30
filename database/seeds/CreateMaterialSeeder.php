<?php
use App\Material;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CreateMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $material = 
                [
                   [
                     'm_desc'=>'MICROFIBER',
                     'm_status'=>'1',
                     'm_stock'=>'1000',
                   ],
                   [
                     'm_desc'=>'INTERLOCK',
                     'm_status'=>'1',
                     'm_stock'=>'1000',
                   ],
                   [
                     'm_desc'=>'BWJ (COTTON)',
                     'm_status'=>'1',
                     'm_stock'=>'1000',
                   ],
                ];
        
        foreach ($material as $key => $value) {
            Material::create($value);
        }
    }
}
