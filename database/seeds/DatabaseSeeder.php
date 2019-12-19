<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateUsersSeeder::class);
        $this->call(CreateSleeveSeeder::class);
        $this->call(CreateNeckSeeder::class);
        $this->call(CreateMaterialSeeder::class);
        $this->call(CreateBodySeeder::class);
        $this->call(CreateDeliverySettingSeeder::class);
        $this->call(BlockDaySeeder::class);
    }
}
