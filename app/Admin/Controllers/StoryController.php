<?php

namespace App\Admin\Controllers;

use App\Models\Catalog;
use App\Models\Story;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Story';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Story());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('slug', __('Slug'));
        $grid->column('image_link', __('Image link'));
        $grid->column('category_id', __('Category id'));
        $grid->column('status', __('Status'));
        $grid->column('continues', __('Continues'));
        $grid->column('view', __('View'));
        $grid->column('author', __('Author'));
        $grid->column('rate_total', __('Rate total'));
        $grid->column('rate_count', __('Rate count'));
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
        $show = new Show(Story::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('description', __('Description'));
        $show->field('site_title', __('Site title'));
        $show->field('meta_desc', __('Meta desc'));
        $show->field('meta_key', __('Meta key'));
        $show->field('image_link', __('Image link'));
        $show->field('category_id', __('Category id'));
        $show->field('status', __('Status'));
        $show->field('continues', __('Continues'));
        $show->field('view', __('View'));
        $show->field('author', __('Author'));
        $show->field('rate_total', __('Rate total'));
        $show->field('rate_count', __('Rate count'));
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
        $form = new Form(new Story());

        $form->text('name', __('Name'));
        $form->text('slug', __('Slug'));
        // $form->ckeditor('description', __('Description'));
        $form->ckeditor('description', __('Description'))->required()->options();
        $form->textarea('site_title', __('Site title'));
        $form->textarea('meta_desc', __('Meta desc'));
        $form->textarea('meta_key', __('Meta key'));
        $form->image('image_link', __('Image link'))->move('upload/stories')->removable();
        $form->multipleSelect('category_id', __('Category'))->options(Catalog::all()->pluck('name', 'id'));
        $form->switch('status', __('Status'))->default(1);
        $form->switch('continues', __('Continues'));
        $form->number('view', __('View'));
        $form->text('author', __('Author'));
        $form->number('rate_total', __('Rate total'));
        $form->number('rate_count', __('Rate count'));

        return $form;
    }
}
