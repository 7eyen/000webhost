<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $guarded = [];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_lessons')->withTimestamps();

    }

    public function getPreviewAttribute($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) ? $value : config('filesystems.disks.admin.url')."/".$value;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(
            function (Model $model) {
                if ( $url = request('image_url')) {
                    $model->preview = $url;
                }
            }
        );

        static::deleting(
            function ($model) {
                $preview = $model->getOriginal('preview');
                //删除关联数据
                $model->tags()->detach();
                //删除对应视频
                $model->videos()->delete();
                //删除图片资源
                $disk = \Storage::disk(config('admin.upload.disk'));
                if ($disk->exists($preview)) {
                    $disk->delete($preview);
                }
                //删除视频资源
                foreach ($model->videos as $video){
                    $path=$video->getOriginal('path');
                    if ($disk->exists($path)) {
                        $disk->delete($path);
                    }
                }
            }
        );
    }
}
