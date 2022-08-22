<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tags::create([
            'name'=> 'Lovely'
        ]);

        Tags::create([
            'name'=> 'Good'
        ]);

        Tags::create([
            'name'=> 'Bad'
        ]);
    }
}
