<?php

namespace app\controller;

use app\BaseController;
use app\model\Message as MessageModel;
use think\exception\ValidateException;

class Message extends BaseController
{
    /**
     * API 基礎響應格式
     */
    protected function success($data = [], $message = 'success', $code = 200)
    {
        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ]);
    }

    protected function error($message = 'error', $code = 400, $data = [])
    {
        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ]);
    }

    /**
     * 獲取留言列表
     * GET /api/messages
     */
    public function index()
    {
        try {
            $page = $this->request->get('page', 1);
            $limit = $this->request->get('limit', 10);
            
            // 獲取分頁數據
            $result = MessageModel::getList($page, $limit);
            
            return $this->success([
                'messages' => $result->items(),
                'total' => $result->total(),
                'page' => $result->currentPage(),
                'limit' => $result->listRows(),
                'pages' => $result->lastPage()
            ]);
        } catch (\Exception $e) {
            return $this->error('獲取留言列表失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 獲取單條留言
     * GET /api/messages/1
     */
    public function show($id)
    {
        try {
            $message = MessageModel::find($id);
            
            if (!$message) {
                return $this->error('留言不存在', 404);
            }

            return $this->success($message->toArray());
        } catch (\Exception $e) {
            return $this->error('獲取留言失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 創建留言
     * POST /api/messages
     */
    public function create()
    {
        try {
            // 獲取 POST 數據
            $data = $this->request->post();
            
            // 數據驗證
            $this->validate($data, [
                'name' => 'require|max:100',
                'email' => 'email|max:255',
                'message' => 'require'
            ], [
                'name.require' => '姓名不能為空',
                'name.max' => '姓名不能超過100個字符',
                'email.email' => 'Email格式不正確',
                'email.max' => 'Email不能超過255個字符',
                'message.require' => '留言內容不能為空'
            ]);

            // 創建留言
            $message = new MessageModel();
            $result = $message->save([
                'name' => trim($data['name']),
                'email' => trim($data['email'] ?? ''),
                'message' => trim($data['message'])
            ]);

            if ($result) {
                return $this->success($message->toArray(), '留言發布成功', 201);
            } else {
                return $this->error('留言發布失敗', 500);
            }
        } catch (ValidateException $e) {
            return $this->error($e->getError(), 422);
        } catch (\Exception $e) {
            return $this->error('留言發布失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 更新留言
     * PUT /api/messages/1
     */
    public function update($id)
    {
        try {
            $message = MessageModel::find($id);
            
            if (!$message) {
                return $this->error('留言不存在', 404);
            }

            // 獲取 PUT 數據
            $data = $this->request->put();
            
            // 數據驗證
            $this->validate($data, [
                'name' => 'require|max:100',
                'email' => 'email|max:255',
                'message' => 'require'
            ], [
                'name.require' => '姓名不能為空',
                'name.max' => '姓名不能超過100個字符',
                'email.email' => 'Email格式不正確',
                'email.max' => 'Email不能超過255個字符',
                'message.require' => '留言內容不能為空'
            ]);

            // 更新留言
            $result = $message->save([
                'name' => trim($data['name']),
                'email' => trim($data['email'] ?? ''),
                'message' => trim($data['message'])
            ]);

            if ($result !== false) {
                return $this->success($message->toArray(), '留言更新成功');
            } else {
                return $this->error('留言更新失敗', 500);
            }
        } catch (ValidateException $e) {
            return $this->error($e->getError(), 422);
        } catch (\Exception $e) {
            return $this->error('留言更新失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 刪除留言
     * DELETE /api/messages/1
     */
    public function delete($id)
    {
        try {
            $message = MessageModel::find($id);
            
            if (!$message) {
                return $this->error('留言不存在', 404);
            }

            $result = $message->delete();

            if ($result) {
                return $this->success([], '留言刪除成功');
            } else {
                return $this->error('留言刪除失敗', 500);
            }
        } catch (\Exception $e) {
            return $this->error('留言刪除失敗: ' . $e->getMessage(), 500);
        }
    }
}