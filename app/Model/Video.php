<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $guarded = [];

    public function getPathAttribute($value)
    {
        return config('filesystems.disks.admin.url').'/'.$value;
    }

    protected static function boot()
    {
        static::deleting(
            function ($model) {
                $disk = \Storage::disk(config('admin.upload.disk'));

                //删除视频资源
                $path = $model->getOriginal('path');
                if ($disk->exists($path)) {
                    $disk->delete($path);
                }

            }
        );
    }
}
