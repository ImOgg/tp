<?php

namespace app\model;

use think\Model;

class Message extends Model
{
    // 設置表名
    protected $name = 'messages';
    
    // 設置主鍵
    protected $pk = 'id';
    
    // 設置自動時間戳
    protected $autoWriteTimestamp = true;
    
    // 設置時間字段格式
    protected $dateFormat = 'Y-m-d H:i:s';
    
    // 設置創建時間字段
    protected $createTime = 'created_at';
    
    // 設置更新時間字段
    protected $updateTime = 'updated_at';
    
    // 設置允許寫入的字段
    protected $field = [
        'id', 'name', 'email', 'message', 'created_at', 'updated_at'
    ];
    
    // 設置驗證規則
    protected $rule = [
        'name' => 'require|max:100',
        'email' => 'email|max:255',
        'message' => 'require'
    ];
    
    // 設置驗證提示信息
    protected $message = [
        'name.require' => '姓名不能為空',
        'name.max' => '姓名不能超過100個字符',
        'email.email' => 'Email格式不正確',
        'email.max' => 'Email不能超過255個字符',
        'message.require' => '留言內容不能為空'
    ];
    
    // 獲取留言列表（按時間倒序）
    public static function getList($page = 1, $limit = 10)
    {
        return self::order('created_at', 'desc')
                   ->paginate([
                       'list_rows' => $limit,
                       'page' => $page
                   ]);
    }
    
    // 創建留言
    public static function createMessage($data)
    {
        $message = new self();
        return $message->save($data);
    }
    
    // 更新留言
    public function updateMessage($data)
    {
        return $this->save($data);
    }
    
    // 刪除留言
    public function deleteMessage()
    {
        return $this->delete();
    }
}