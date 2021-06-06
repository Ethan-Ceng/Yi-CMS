<?php


namespace app\common\exception;


class TokenException extends BaseException
{
    public $httpStatus = 401;
    // 自定义错误码 正常 0，异常 1, 10000
    public $resultCode = 10000;
    // 错误具体信息
    public $resultMsg = 'Token 已过期或无效Token！';
}