<?php

namespace App\Http\Controllers\Api;

use App\Model\Lesson;
use App\Model\Tag;
use App\Model\TagLesson;
use App\Model\Video;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ContentController extends CommonController
{
    /**
     * 获取视频标签
     * @return array
     */
    public function tags()
    {
        return $this->response(Tag::get());
    }

    /**
     * 获取课程
     * @param $tid
     * @return array
     */
    public function lesson($tid)
    {
        if ($tid) {
            $data = Lesson::whereHas(
                'tags',
                function ($query) use ($tid) {
                    $query->where('tag_id', $tid);
                }
            )->get();

            //dd($data->toArray());
            /**原方法
             * $data = DB::table('lessons')
             * ->select('lessons.*')
             * ->join('tag_lessons', 'lessons.id', '=', 'tag_lessons.lesson_id')
             * ->where('tag_id', $tid)
             * ->get();
             * dd($data);
             * foreach ($data as $v) {
             * $v->preview = config('filesystems.disks.qiniu.url').$v->preview;
             * }*/
        } else {
            $data = Lesson::all();
        }

        return $this->response($data);
    }

    /**
     * 获取推荐课程
     * @param $row
     * @return array
     */
    public function commendLesson($row)
    {
        $data = Lesson::where('iscommend', 1)->limit($row)->get();

        return $this->response($data);

    }

    /**
     * 获取热门课程
     * @param $row
     * @return array
     */
    public function hotLesson($row)
    {
        $data = Lesson::where('ishot', 1)->limit($row)->get();

        return $this->response($data);

    }

    /**
     * 获取视频列表
     * @param $lessonId
     * @return array
     */
    public function videos($lessonId)
    {
        $data = Video::where('lesson_id', $lessonId)->get();

        return $this->response($data);
    }


}
