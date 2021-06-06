<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::post('login', 'Login/index');

// 所有需要权限管理 ->middleware('auth');
Route::group(function () {
    Route::get('admin/list', 'AdminUser/list');
    Route::post('admin/add', 'AdminUser/create');
    Route::post('admin/update', 'AdminUser/update');
});

// 上传
Route::post('upload/avatar', 'Upload/uploadAvatar');
