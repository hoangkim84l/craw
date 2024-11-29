<?php

namespace App\Admin\Controllers;

use App\Models\Chapter;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChapterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Chapter';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Chapter());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('slug', __('Slug'));
        $grid->column('site_title', __('Site title'));
        $grid->column('meta_desc', __('Meta desc'));
        $grid->column('meta_key', __('Meta key'));
        $grid->column('story_id', __('Story id'));
        $grid->column('image_link', __('Image link'));
        $grid->column('audio_link', __('Audio link'));
        $grid->column('show_img', __('Show img'));
        $grid->column('content', __('Content'));
        $grid->column('author', __('Author'));
        $grid->column('status', __('Status'));
        $grid->column('ordering', __('Ordering'));
        $grid->column('view', __('View'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Chapter::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('site_title', __('Site title'));
        $show->field('meta_desc', __('Meta desc'));
        $show->field('meta_key', __('Meta key'));
        $show->field('story_id', __('Story id'));
        $show->field('image_link', __('Image link'));
        $show->field('audio_link', __('Audio link'));
        $show->field('show_img', __('Show img'));
        $show->field('content', __('Content'));
        $show->field('author', __('Author'));
        $show->field('status', __('Status'));
        $show->field('ordering', __('Ordering'));
        $show->field('view', __('View'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Chapter());

        $form->text('name', __('Name'));
        $form->text('slug', __('Slug'));
        $form->textarea('site_title', __('Site title'));
        $form->textarea('meta_desc', __('Meta desc'));
        $form->textarea('meta_key', __('Meta key'));
        $form->number('story_id', __('Story id'));
        $form->textarea('image_link', __('Image link'));
        $form->textarea('audio_link', __('Audio link'));
        $form->number('show_img', __('Show img'));
        $form->textarea('content', __('Content'));
        $form->text('author', __('Author'));
        $form->switch('status', __('Status'))->default(1);
        $form->number('ordering', __('Ordering'));
        $form->number('view', __('View'));

        return $form;
    }
}
