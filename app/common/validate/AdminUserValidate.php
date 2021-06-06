<?php


namespace app\common\validate;


class AdminUserValidate extends BaseValidate
{
    protected $rule = [
        'email' => 'require|email',
        'password' => 'require|min:3|max:20'
    ];

    protected $message = [
        'email' => '邮箱格式错误',
        'password' => '密码必须是3～20个字符'
    ];
}