<?php
// +----------------------------------------------------------------------
// | 多語言設置
// +----------------------------------------------------------------------

return [
    // 預設語言
    'default_lang'        => env('DEFAULT_LANG', 'zh-tw'),
    // 自動偵測瀏覽器語言
    'auto_detect_browser' => true,
    // 允許的語言列表
    'allow_lang_list'     => [],
    // 多語言自動偵測變數名
    'detect_var'          => 'lang',
    // 是否使用Cookie記錄
    'use_cookie'          => true,
    // 多語言cookie變數
    'cookie_var'          => 'think_lang',
    // 多語言header變數
    'header_var'          => 'think-lang',
    // 擴展語言包
    'extend_list'         => [],
    // Accept-Language轉義為對應語言包名稱
    'accept_language'     => [
        'zh-hans-cn' => 'zh-cn',
        'zh-hant-tw' => 'zh-tw',
        'zh-tw' => 'zh-tw',
    ],
    // 是否支援語言分組
    'allow_group'         => false,
];
