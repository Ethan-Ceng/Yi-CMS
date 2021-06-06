<?php


namespace app\common\validate;


class CategoryValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|max:50',
    ];

    protected $message = [
        'name' => '分类名不能为空',
    ];
}