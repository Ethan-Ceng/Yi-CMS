<?php


namespace app\admin\controller;


use app\BaseController;
use app\common\model\mysql\AdminUser as AdminUserModel;

class AdminUser extends BaseController
{
    public function list()
    {
        $pageSize = $this->request->param('pageSize');
        // 分页查询
        $adminUser = new AdminUserModel();
        $result = $adminUser->paginate($pageSize);
        $result->hidden(['password'])->toArray();
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
            $adminUser = new AdminUserModel();
            $user = $adminUser->checkUserByEmail($data['email']);

            if ($user) {
                return json(['resultMsg' => '用户已存在', 'resultCode' => 1]);
            }

            $data['password'] = md5($data['password'] . config('system.pwd_salt'));
            $data['username'] = '管理员';

            $data['status'] = 0;

            $admin = $adminUser->save($data);
            return json([
                'data' => ['user' => $admin],
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