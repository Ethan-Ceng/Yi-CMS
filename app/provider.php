<?php

use app\Request;
// use app\ExceptionHandle;
use app\common\exception\ExceptionHandler;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    // 绑定自定义异常处理handle类
    // 'think\exception\Handle' => ExceptionHandle::class,
    'think\exception\Handle' => ExceptionHandler::class,
];
