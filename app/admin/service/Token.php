<?php
/**
 * Token 数据结构
 * @key token 生成唯一32位字符串
 * @value $values
 *          uid 用户id
 *
 */

namespace app\admin\service;



use app\common\exception\MessageException;

class Token
{
    public function getToken($values)
    {
        $token = self::generateToken();
        $expire_in = config('system.token_expire');
        $result = cache($token, json_encode($values), $expire_in);
        if (!$result) {
            throw new MessageException([
                'resultMsg' => '服务器缓存异常',
                'resultCode' => 10005
            ]);
        }
        return $token;
    }

    // 生成 Token
    private static function generateToken()
    {
        // 32位组成的随机字符串
        $randChars = getRandChar(32);
        // 用三组字符串md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // 加盐
        $salt = config('system.token_salt');
        return md5($randChars . $timestamp . $salt);
    }
}