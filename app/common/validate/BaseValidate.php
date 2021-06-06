<?php


namespace app\common\validate;


use app\common\exception\ParameterException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 获取Http 参数
     * 对所有参数进行校验
     */
    public function goCheck()
    {
        $params = Request::param();
        $result = $this->batch()->check($params);

        if (!$result) {
            throw new ParameterException([
                'resultMsg' => $this->error
            ]);
        } else {
            return true;
        }
    }
}