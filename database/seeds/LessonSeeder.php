<?php

use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return;
        \App\Model\Lesson::truncate();
        factory(App\Model\Lesson::class, 100)->create();
    }
}
