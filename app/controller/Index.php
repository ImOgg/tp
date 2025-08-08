<?php

namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        // API 模式：返回 JSON 數據
        return json([
            'code' => 200,
            'message' => 'success',
            'data' => [
                'framework' => 'ThinkPHP',
                'version' => \think\facade\App::version(),
                'timestamp' => time()
            ]
        ]);
    }

    public function hello($name = 'ThinkPHP8')
    {
        // API 模式：返回 JSON 格式
        return json([
            'code' => 200,
            'message' => 'success',
            'data' => [
                'greeting' => "hello, {$name}",
                'timestamp' => time()
            ]
        ]);
    }
}
