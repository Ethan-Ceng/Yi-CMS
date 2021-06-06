<?php
/**
 * 自定义错误处理基类
 * 对内部所有错误统一返回数据格式
 */

namespace app\common\exception;


use think\Exception;

class BaseException extends Exception
{
    /**
     * http status 400,200
     * 2** 请求成功
     *
     * 4** 请求错误，妨碍服务器处理
     * 400 错误请求
     * 401 未授权，请求要求身份验证
     * 403 禁止，服务器拒绝请求
     * 404 未找到，服务器找不到请求资源
     *
     * 500 （服务器内部错误） 服务器遇到错误，无法完成请求。
     */
    public $httpStatus = 400;
    // 自定义错误码 正常 0，异常 1
    public $resultCode = 1;
    // 错误具体信息
    public $resultMsg = '参数错误';


    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }

        if (array_key_exists('httpStatus', $params)) {
            $this->httpStatus = $params['httpStatus'];
        }

        /**
         * notify
         * 返回数据提中不能使用message字段，与TP6框架中冲突
         * vendor/topthink/framework/src/think/exception/Handle.php
         * message must string Handle strpos($message, ':')
         */
        if (array_key_exists('resultMsg', $params)) {
            $this->resultMsg = $params['resultMsg'];
        }

        if (array_key_exists('resultCode', $params)) {
            $this->resultCode = $params['resultCode'];
        }
    }
}