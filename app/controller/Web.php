<?php

namespace app\controller;

use app\BaseController;

class Web extends BaseController
{
    /**
     * 儀表板頁面
     */
    public function dashboard()
    {
        // 準備數據傳遞給模板
        $data = [
            'version' => \think\facade\App::version(),
            'php_version' => PHP_VERSION,
            'current_time' => date('Y-m-d H:i:s'),
            'user' => [
                'name' => 'Admin User',
                'email' => 'admin@example.com'
            ],
            'activities' => [
                '✅ API 路由已配置',
                '✅ 控制器已創建',
                '✅ Dashboard 頁面已建立',
                '✅ 模板系統已啟用'
            ]
        ];

        // 使用模板渲染
        return view('web/dashboard', $data);
    }





    /**
     * 留言板頁面
     */
    public function admin()
    {
        return view('web/admin');
    }
}
