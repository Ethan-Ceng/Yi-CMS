<?php


namespace app\admin\controller;


use app\BaseController;
use app\common\exception\TokenException;

class AuthToken extends BaseController
{
    public $account;

    // 初始化
    protected function initialize()
    {
        $isLogin = $this->verifyToken();
        if (!$isLogin) {
            throw new TokenException();
        }
    }

    public function verifyToken()
    {
        // 获取 token 信息
        $exist = $this->getToken();
        if ($exist) {
            return true;
        } else {
            return false;
        }
    }

    public function getToken()
    {
        // token: user scope
        $token = $this->request->header('token');
        if (!$token) {
            throw new TokenException(['message' => '请求Token缺省！']);
        }
        $vars = cache($token);
        var_dump($vars);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
        }

        $this->account = $vars;
        return $vars;
    }
}