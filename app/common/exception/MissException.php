<?php


namespace app\common\exception;


class MissException extends BaseException
{
    public $httpStatus = 200;
    // 自定义错误码 正常 0，异常 1
    public $resultCode = 1;
    // 错误具体信息
    public $resultMsg = '查询不到结果';
}