<?php

namespace App\Admin\Controllers;

use App\Model\Lesson;
use App\Model\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class LessonController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '课程';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Lesson);

        $grid->column('id', __('Id'))->expand(
            function ($model) {
                $comments = $model->videos()->take(10)->get()->map(
                    function ($comment) {
                        return $comment->only(['id', 'title', 'path']);
                    }
                );

                return new Table(['ID', '内容', '发布时间'], $comments->toArray());
            }
        );
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('title', __('标题'));
        $grid->column('introduce', __('Introduce'));
        $grid->column('preview', __('Preview'))->image('', 100, 100);
        $grid->column('标记')->switchGroup(
            [
                'ishot'     => '热门',
                'iscommend' => '推荐',
            ],
            [
                'on'  => ['text' => '是'],
                'off' => ['text' => '否'],
            ]
        );
        $grid->column('click', __('Click'));
        $grid->column('videos', '视频数')->display(
            function ($comments) {
                $count = count($comments);

                return "<span class='label label-warning'>{$count}</span>";
            }
        );

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Lesson::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('title', __('Title'));
        $show->field('introduce', __('Introduce'));
        $show->field('preview', __('Preview'));
        $show->field('iscommend', __('Iscommend'));
        $show->field('ishot', __('Ishot'));
        $show->field('click', __('Click'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Lesson);

        $form->text('title', __('Title'))->required();
        $form->text('introduce', __('Introduce'))->required();
        $form->image('preview', __('预览图'));
        $form->text('image_url', '或者直接输入图片url');
        $form->ignore('image_url');
        $form->switch('iscommend', __('Iscommend'));
        $form->switch('ishot', __('Ishot'));
        $form->number('click', __('Click'))->default(0);
        $form->multipleSelect('tags')->options(Tag::all()->pluck('name', 'id'));
//        $form->file('video', "ss")->rules('mimes:jpeg,png,jpg,gif')->options(
//            [
//                'initialPreviewConfig' => [['filetype' => 'video/mp4']],
//                'initialPreviewFileType' => 'video',
//                'dropZoneEnabled'        => true,
//                'allowedFileTypes'       => ['video'],
//
//                'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif'],
//
//
//            ]
//        );
        $form->hasMany(
            'videos',
            '课程视频',
            function (Form\NestedForm $form) {
                $form->text('title', '标题')->required();
                $form->file('path', '地址')->options(
                    [
                        'initialPreviewConfig'   => [['filetype' => 'video/mp4']],
                        'initialPreviewFileType' => 'video',
                        //'dropZoneEnabled'        => true,
                        'allowedFileTypes'       => ['video'],

                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif'],
                    ]
                )->rules('mimes:mp4', ['mimes' => '格式错误']);
            }
        );

        /* $form->table('extra','课程视频', function ($table) {
             $table->text('videos.title','视频标题');
             $table->text('videos.path','视频路径');
         });*/

        return $form;
    }
}
