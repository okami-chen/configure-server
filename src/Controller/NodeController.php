<?php

namespace OkamiChen\ConfigureServer\Controller;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use OkamiChen\ConfigureServer\Entity\ConfigureGroup;
use OkamiChen\ConfigureServer\Entity\ConfigureNode;
use Encore\Admin\Grid\Displayers\Actions;
use OkamiChen\ConfigureServer\Service\ConfigureServer;

class NodeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        $cache = ConfigureServer::all();
        ConfigureServer::clear();
        return Admin::content(function (Content $content) {

            $content->header('配置管理');
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

            $content->header('配置管理');
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

            $content->header('配置管理');
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
        return Admin::grid(ConfigureNode::class, function (Grid $grid) {

            $grid->id('编号')->sortable();
            $grid->column('group.title', '组名称');
            $grid->column('group.ip', '组IP');
            $grid->column('skey', '键名');
            $grid->column('svalue', '键值')->display(function($value){
                if(json_decode($value)){
                    return '请点编辑查看';
                }
                return $value;
            });
            $grid->column('remark', '描述');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
            
            $grid->model()->with(['group'])->orderBy('id','desc');
            $grid->actions(function(Actions $action){
                $action->disableDelete();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ConfigureNode::class, function (Form $form) {

            $form->display('id', '编号');

            $form->select('group_id', '分组')
                    ->options(ConfigureGroup::pluck('title','id'));
            $form->text('skey', '键名')
                    ->placeholder('例如:database.host')
                    ->rules('required');
            $form->textarea('svalue', '键值')
                    ->rules('required')
                    ->placeholder('允许使用Json格式');
            $form->text('remark', '描述')
                    ->rules('required')
                    ->placeholder('填写描述是个好习惯');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
