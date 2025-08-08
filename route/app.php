<?php
// +----------------------------------------------------------------------
// | Web 路由定義
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

// 首頁路由
Route::get('/', 'index/index');

// 測試路由
Route::get('think', function () {
    return 'hello,ThinkPHP8!';
});

// Hello 路由
Route::get('hello/:name', 'index/hello');

// Web 頁面路由組
Route::group('web', function () {
    Route::get('dashboard', 'web/dashboard');
    Route::get('messages', 'web/admin');     // 留言板頁面（指向 admin）
});
