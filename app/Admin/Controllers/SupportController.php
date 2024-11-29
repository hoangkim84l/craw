<?php

namespace App\Admin\Controllers;

use App\Models\Support;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SupportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Support';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Support());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('gmail', __('Gmail'));
        $grid->column('skype', __('Skype'));
        $grid->column('phone', __('Phone'));
        $grid->column('hotline', __('Hotline'));
        $grid->column('fanpage_fb', __('Fanpage fb'));
        $grid->column('fanpage_twitter', __('Fanpage twitter'));
        $grid->column('fanpage_linkedin', __('Fanpage linkedin'));
        $grid->column('site_title', __('Site title'));
        $grid->column('site_key', __('Site key'));
        $grid->column('site_desc', __('Site desc'));
        $grid->column('zalo', __('Zalo'));
        $grid->column('facebook', __('Facebook'));
        $grid->column('logo', __('Logo'));
        $grid->column('slogan', __('Slogan'));
        $grid->column('favicon', __('Favicon'));
        $grid->column('sort_order', __('Sort order'));
        $grid->column('robots', __('Robots'));
        $grid->column('author', __('Author'));
        $grid->column('copyright', __('Copyright'));
        $grid->column('geo_region', __('Geo region'));
        $grid->column('geo_placename', __('Geo placename'));
        $grid->column('og_image', __('Og image'));
        $grid->column('og_type', __('Og type'));

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
        $show = new Show(Support::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('gmail', __('Gmail'));
        $show->field('skype', __('Skype'));
        $show->field('phone', __('Phone'));
        $show->field('hotline', __('Hotline'));
        $show->field('fanpage_fb', __('Fanpage fb'));
        $show->field('fanpage_twitter', __('Fanpage twitter'));
        $show->field('fanpage_linkedin', __('Fanpage linkedin'));
        $show->field('site_title', __('Site title'));
        $show->field('site_key', __('Site key'));
        $show->field('site_desc', __('Site desc'));
        $show->field('zalo', __('Zalo'));
        $show->field('facebook', __('Facebook'));
        $show->field('logo', __('Logo'));
        $show->field('slogan', __('Slogan'));
        $show->field('favicon', __('Favicon'));
        $show->field('sort_order', __('Sort order'));
        $show->field('robots', __('Robots'));
        $show->field('author', __('Author'));
        $show->field('copyright', __('Copyright'));
        $show->field('geo_region', __('Geo region'));
        $show->field('geo_placename', __('Geo placename'));
        $show->field('og_image', __('Og image'));
        $show->field('og_type', __('Og type'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Support());

        $form->text('name', __('Name'));
        $form->text('gmail', __('Gmail'));
        $form->text('skype', __('Skype'));
        $form->mobile('phone', __('Phone'));
        $form->text('hotline', __('Hotline'));
        $form->text('fanpage_fb', __('Fanpage fb'));
        $form->text('fanpage_twitter', __('Fanpage twitter'));
        $form->text('fanpage_linkedin', __('Fanpage linkedin'));
        $form->textarea('site_title', __('Site title'));
        $form->textarea('site_key', __('Site key'));
        $form->textarea('site_desc', __('Site desc'));
        $form->textarea('zalo', __('Zalo'));
        $form->textarea('facebook', __('Facebook'));
        $form->textarea('logo', __('Logo'));
        $form->textarea('slogan', __('Slogan'));
        $form->text('favicon', __('Favicon'));
        $form->switch('sort_order', __('Sort order'));
        $form->text('robots', __('Robots'));
        $form->text('author', __('Author'));
        $form->text('copyright', __('Copyright'));
        $form->text('geo_region', __('Geo region'));
        $form->text('geo_placename', __('Geo placename'));
        $form->text('og_image', __('Og image'));
        $form->text('og_type', __('Og type'));

        return $form;
    }
}
