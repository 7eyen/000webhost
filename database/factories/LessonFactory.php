<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Lesson::class, function (Faker $faker) {
    return [
        'title'=>$faker->text(30),
        'preview'=>$faker->imageUrl($width = 640, $height = 480,'cats',true,'',0),
        //TODO 模型关联
        'iscommend'=>rand(0,1),
        'ishot'=>rand(0,1),
    ];
});
