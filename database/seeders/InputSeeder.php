<?php

namespace Database\Seeders;

use App\Http\Controllers\System\InputSeederController;
use Illuminate\Database\Seeder;

class InputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input_ctrl = new InputSeederController();
        $input_ctrl->input();
    }
}
