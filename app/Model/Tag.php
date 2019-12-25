<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $guarded = [];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'tag_lessons');
    }

    /**
     * 删除中间关联数据
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function ($model) {
                $model->lessons()->detach();
            }
        );
    }
}

