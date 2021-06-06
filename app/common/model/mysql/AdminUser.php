<?php


namespace app\common\model\mysql;


class AdminUser extends BaseModel
{
// 设置当前模型对应的完整数据表名称
    protected $table = 'admin_user';

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
            exception('传递参数错误');
        }

        $data['password'] = md5($data['password'] . config('system.pwd_salt'));

        return $this->data($data)->save();
    }

    public function checkUserByEmail($email)
    {
        if (!$email) {
            exception('用户名不合法');
        }

        $data = ['email' => $email];
        return $this->where($data)->find();
    }
}