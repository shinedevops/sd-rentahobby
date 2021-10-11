<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key'   => 'date',
                'value' => 'Y-m-d',
                'hidden' => 'No',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'key'   => 'time',
                'value' => 'H:i:a',
                'hidden' => 'No',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'key'   => 'datetime',
                'value' => 'Y-m-d H:i:a',
                'hidden' => 'No',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'key'   =>  'jquerydate',
                'value' =>  'yy-mm-dd',
                'hidden' => 'Yes',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'key'   =>  'pagination',
                'value' =>  '10',
                'hidden' => 'No',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
        ];

        Setting::insert($settings);
    }
}
