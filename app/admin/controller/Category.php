<?php


namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\Category as CategoryModel;
use app\common\exception\MessageException;

class Category extends BaseController
{
    // 列表所有
    public function list()
    {
        $pageSize = $this->request->param('pageSize');
        // 分页查询
        $adminUser = new CategoryModel();
        $result = $adminUser->paginate($pageSize);
        $result->hidden([])->toArray();
        return json([
            'data' => $result,
            'resultCode' => 0,
            'resultMsg' => '查询成功'
        ]);
    }

    /**
     * 返回树状结构
     */
    public function getCategoryTree()
    {
        // 分页查询
        $CategoryModel = new CategoryModel();
        $result = $CategoryModel->getCategoryTree();
        // $result->hidden([])->toArray();
        return json([
            'data' => $result,
            'resultCode' => 0,
            'resultMsg' => '查询成功'
        ]);
    }

    public function create()
    {
        if (!$this->request->isPost()) {
            throw new MessageException(['resultMsg' => '请求方法不允许']);
        }
        $data = $this->request->param();
        try {
            $CategoryModel = new CategoryModel();
            $name = $CategoryModel->checkName($data['name']);

            if ($name) {
                return json(['resultMsg' => '分类名存在', 'resultCode' => 1]);
            }

            // 没有pid 默认为顶级分类
            if (empty($data['pid'])) {
                $data['pid'] = 0;
            }

            $data['status'] = 1;

            $res = $CategoryModel->save($data);
            return json([
                'data' => ['category' => $res],
                'resultMsg' => '添加成功',
                'resultCode' => 0
            ]);
        } catch (\Exception $e) {
            throw new MessageException(['resultMsg' => $e->getMessage()]);
        }
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}