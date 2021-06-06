<?php
/**
 * 参数错误类
 */

namespace app\common\exception;


class ParameterException extends BaseException
{
    public $httpStatus = 400;
    // 自定义错误码 正常 0，异常 1
    public $resultCode = 1;
    // 错误具体信息
    public $resultMsg = '参数错误';
}