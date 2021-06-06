<?php


namespace app\common\model\mysql;

use app\common\exception\MessageException;


class User extends BaseModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'user';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 模型初始化
    protected static function init()
    {
        // TODO:初始化内容
    }

    public function add($data)
    {
        if (!is_array($data)) {
            throw new MessageException(['resultMsg' => '传递参数错误']);
        }

        $data['password'] = md5($data['password'] . config('system.pwd_salt'));

        return $this->data($data)->save();
    }

    public function checkUserByEmail($email)
    {
        if (!$email) {
            throw new MessageException(['resultMsg' => '传递参数错误']);
        }

        $data = ['email' => $email];
        return $this->where($data)->find();
    }


    public function getUserById($id)
    {
        $id = intval($id);
        if (!$id) {
            throw new MessageException(['resultMsg' => '传递参数错误']);
        }

        return $this->find($id);
    }
}