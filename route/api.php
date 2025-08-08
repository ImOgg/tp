<?php
// +----------------------------------------------------------------------
// | API 路由定義
// +----------------------------------------------------------------------
use think\facade\Route;

// API 路由組 - 統一添加 /api 前綴
Route::group('api', function () {
    
    // 基礎 API 信息
    Route::get('/', function () {
        return json([
            'name' => 'ThinkPHP 留言板 API',
            'version' => 'v1.0',
            'framework' => \think\facade\App::version(),
            'timestamp' => time(),
            'endpoints' => [
                'GET /api/messages' => '獲取留言列表',
                'POST /api/messages' => '創建留言',
                'GET /api/messages/{id}' => '獲取單條留言',
                'PUT /api/messages/{id}' => '更新留言',
                'DELETE /api/messages/{id}' => '刪除留言'
            ]
        ]);
    });

    // 留言板 API
    Route::group('messages', function () {
        Route::get('/', 'message/index');        // GET /api/messages
        Route::get('/:id', 'message/show');      // GET /api/messages/1
        Route::post('/', 'message/create');      // POST /api/messages
        Route::put('/:id', 'message/update');    // PUT /api/messages/1
        Route::delete('/:id', 'message/delete'); // DELETE /api/messages/1
    });

});

// 健康檢查端點
Route::get('health', function () {
    return json([
        'status' => 'ok',
        'service' => 'ThinkPHP 留言板',
        'timestamp' => time()
    ]);
});