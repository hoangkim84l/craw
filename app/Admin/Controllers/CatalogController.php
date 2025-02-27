<?php

namespace App\Admin\Controllers;

use App\Models\Catalog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CatalogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Catalog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Catalog());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('slug', __('Slug'));
        $grid->column('parent_id', __('Parent id'));
        $grid->column('lft', __('Lft'));
        $grid->column('rght', __('Rght'));
        $grid->column('description', __('Description'));
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
        $show = new Show(Catalog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('parent_id', __('Parent id'));
        $show->field('lft', __('Lft'));
        $show->field('rght', __('Rght'));
        $show->field('description', __('Description'));
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
        $form = new Form(new Catalog());

        $form->text('name', __('Name'));
        $form->text('slug', __('Slug'));
        $form->number('parent_id', __('Parent id'));
        $form->number('lft', __('Lft'));
        $form->number('rght', __('Rght'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
