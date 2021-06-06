<?php

namespace app\index\controller;

class Error {
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method
        $result = [
            'resultCode'=> 0,
            'resultMsg' => '请求路径错误',
            'data' => ''
        ];

        return json($result, 400);
    }
}