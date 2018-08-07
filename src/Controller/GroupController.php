<?php

namespace OkamiChen\ConfigureServer\Controller;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use OkamiChen\ConfigureServer\Entity\ConfigureGroup;

class GroupController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('配置分组');
            $content->description('');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('配置分组');
            $content->description('');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('配置分组');
            $content->description('');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ConfigureGroup::class, function (Grid $grid) {

            $grid->id('编号')->sortable();
            $grid->column('title', '名称');
            $grid->column('ip', 'IP');
            $grid->column('intro', '描述');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ConfigureGroup::class, function (Form $form) {

            $form->display('id', '编号');
            $form->text('title', '名称')->rules('required');
            $form->text('ip', 'IP')->rules('required');
            $form->text('intro', '描述')->rules('required');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
    
    public function destroy($id) {
        
        $ret = ConfigureGroup::with(['nodes'])
                ->where(['id'=>$id])
                ->first();
        if(count($ret->nodes->toArray())){
            return response()->json([
                'status'  => false,
                'message' => '该分组有节点,禁止删除',
            ]);
        }
        
        if($ret->ip == '0.0.0.0'){
            return response()->json([
                'status'  => false,
                'message' => '默认节点,禁止删除',
            ]);            
        }
        
        
        if ($this->form()->destroy($id)) {
            return response()->json([
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ]);
        }
    }
}
