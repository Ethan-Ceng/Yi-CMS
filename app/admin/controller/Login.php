<?php


namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\AdminUser as AdminUserModel;
use app\common\validate\AdminUserValidate;
use app\common\exception\MessageException;
use app\admin\service\Token;

class Login extends BaseController
{
    public function index()
    {
        (new AdminUserValidate())->goCheck();
        $data = $this->request->param();
        try {
            $adminUser = new AdminUserModel();
            $user = $adminUser->checkUserByEmail($data['email']);

            if (!$user || $user->status != 0) {
                return json(['resultMsg' => '用户不存在', 'resultCode' => 1]);
            }
            // var_dump($user);
            if ($user->password !== md5($data['password'] . config('system.pwd_salt'))) {
                return json(['resultMsg' => '密码不正确', 'resultCode' => 1]);
            }
            // 登录成功 todo 更新用户操作日志 是否需要管理 session
            // session(config('system.session_scope'), $user);
            $user->hidden(['password', 'create_time', 'update_time']);
            // 缓存数据 生成token
            $tokenService = new Token();
            $token = $tokenService->getToken($user);
            return json([
                'data' => ['token' => $token, 'user' => $user],
                'resultMsg' => '登录成功',
                'resultCode' => 0
            ]);
        } catch (\Exception $e) {
            throw new MessageException(['resultMsg' => $e->getMessage()]);
        }
    }

    public function logout($token)
    {
        // 删除缓存数据 需要判断token是否本用户
        // cache($token, NULL);
    }
}