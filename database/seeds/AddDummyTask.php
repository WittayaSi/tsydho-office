<?php

use Illuminate\Database\Seeder;

class AddDummyTask extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
         	['task'=>'Finacial forum','description' => 'Finacial forum description', 'start_date'=>'2018-11-12', 'end_date'=>'2018-11-15'],
         	['task'=>'Devtalk', 'description' => 'Devtalk description', 'start_date'=>'2018-11-13', 'end_date'=>'2018-11-25'],
         	['task'=>'Super Event', 'description' => 'Super Event description', 'start_date'=>'2018-11-23', 'end_date'=>'2018-11-24'],
         	['task'=>'wtf event', 'description' => 'wtf event description', 'start_date'=>'2018-11-19', 'end_date'=>'2018-11-27'],
        ];
        \DB::table('tasks')->insert($data);
    }
}
