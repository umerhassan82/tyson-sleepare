<?php

namespace App\Admin\Controllers;

use App\Models\Shop\HomeProduct;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Shop\ShopBrands;

class HomeProductController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HomeProduct);

        $grid->id('Id');
        $grid->name('Name');
        $grid->slug('Slug');
        $grid->firmness('Firmness')->editable();
        $grid->css_class('CSS Class')->editable();
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->brand_id('Brand id');

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
        $show = new Show(HomeProduct::findOrFail($id));

        $show->id('Id');
        $show->image('Image');
        $show->discount_code('Discount code');
        $show->discount_amount('Discount amount');
        $show->slug('Slug');
        $show->affiliate_link('Affiliate link');
        $show->firmness('Firmness');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->brand_id('Brand id');
        $show->deleted_at('Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HomeProduct);

        $form->text('name', 'Name');
        $form->text('image', 'Image');
        $form->text('slug', 'Slug');
        $form->text('affiliate_link', 'Affiliate link');
        $form->text('firmness', 'Firmness');
        $form->text('css_class', 'CSS Class');
        $form->select('brand_id', 'Brand')->options(ShopBrands::all()->pluck('name','id'));

        $form->table('sizes', function ($table) {
            $table->text("name", "Name");
            $table->text("code", "Discounted Code");
            $table->text("amount","Discounted Amount");
        });

        return $form;
    }
}
