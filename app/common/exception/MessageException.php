<?php


namespace app\common\exception;


class MessageException extends BaseException
{
    public $httpStatus = 200;
    // 自定义错误码 正常 0，异常 1
    public $resultCode = 1;
    // 错误具体信息
    public $resultMsg = 'some message';
}