<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板 - ThinkPHP</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Microsoft YaHei', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .header h1 {
            color: #333;
            margin: 0;
            font-size: 2.5em;
        }

        .header p {
            color: #666;
            margin: 10px 0 0 0;
        }

        .nav {
            margin: 20px 0;
            text-align: center;
        }

        .nav a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .nav a:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }

        .nav a.active {
            background: #4c51bf;
        }

        /* 表單樣式 */
        .form-section {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        /* 按鈕樣式 */
        .btn {
            background: #48bb78;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
            margin-right: 10px;
        }

        .btn:hover {
            background: #38a169;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #f56565;
        }

        .btn-danger:hover {
            background: #e53e3e;
        }

        .btn-warning {
            background: #ed8936;
        }

        .btn-warning:hover {
            background: #dd6b20;
        }

        .btn-secondary {
            background: #a0aec0;
        }

        .btn-secondary:hover {
            background: #718096;
        }

        /* 留言項目樣式 */
        .item {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .item:hover {
            transform: translateY(-2px);
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .item-title {
            font-weight: bold;
            color: #667eea;
            font-size: 18px;
        }

        .item-meta {
            color: #718096;
            font-size: 12px;
        }

        .item-content {
            margin: 15px 0;
            line-height: 1.6;
            color: #2d3748;
        }

        .item-actions {
            margin-top: 15px;
        }

        /* 載入動畫 */
        .loading {
            text-align: center;
            padding: 20px;
            color: #667eea;
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #667eea;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* 響應式設計 */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 2em;
            }

            .nav a {
                margin: 5px;
                padding: 8px 16px;
            }

            .item-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>💬 留言板</h1>
            <p>歡迎留下您的寶貴意見</p>
        </div>

        <div class="nav">
            <a href="/web/dashboard">Dashboard</a>
            <a href="/web/messages" class="active">留言板</a>
        </div>

        <!-- 新增留言表單 -->
        <div class="form-section">
            <h3>✍️ 發表留言</h3>
            <form id="messageForm">
                <div class="form-group">
                    <label>姓名 *</label>
                    <input type="text" id="name" name="name" required placeholder="請輸入您的姓名" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" name="email" placeholder="請輸入您的 Email（選填）" />
                </div>
                <div class="form-group">
                    <label>留言內容 *</label>
                    <textarea id="message" name="message" required placeholder="請輸入您的留言內容"></textarea>
                </div>
                <button type="submit" class="btn">發布留言</button>
                <button type="button" class="btn btn-secondary" onclick="clearForm()">清空表單</button>
            </form>
        </div>

        <!-- 留言列表 -->
        <div id="messagesList">
            <h3>📋 留言列表</h3>
            <div id="messages-container" class="loading">
                載入中...
            </div>
        </div>
    </div>

    <script>
        // 設置 axios 默認配置
        axios.defaults.headers.common['Content-Type'] = 'application/json';

        let editingMessageId = null;

        // 頁面載入時獲取留言列表
        document.addEventListener('DOMContentLoaded', function() {
            loadMessages();
        });

        // 表單提交事件
        document.getElementById('messageForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                message: formData.get('message')
            };

            try {
                let response;
                if (editingMessageId) {
                    // 更新留言
                    response = await axios.put(`/api/messages/${editingMessageId}`, data);
                } else {
                    // 創建新留言
                    response = await axios.post('/api/messages', data);
                }

                if (response.data.code === 201 || response.data.code === 200) {
                    alert(editingMessageId ? '留言更新成功！' : '留言發布成功！');
                    clearForm();
                    loadMessages(); // 重新載入留言列表
                } else {
                    alert('操作失敗: ' + response.data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                if (error.response && error.response.data) {
                    alert('操作失敗: ' + error.response.data.message);
                } else {
                    alert('請求失敗: ' + error.message);
                }
            }
        });

        // 載入留言列表
        async function loadMessages() {
            try {
                document.getElementById('messages-container').innerHTML = '<div class="loading">載入中...</div>';

                console.log('正在載入留言...');
                const response = await axios.get('/api/messages');
                console.log('API 響應:', response);

                if (response.data.code === 200) {
                    console.log('留言數據:', response.data.data.messages);
                    displayMessages(response.data.data.messages);
                } else {
                    console.error('API 錯誤:', response.data);
                    document.getElementById('messages-container').innerHTML = '<p style="color: red;">載入失敗: ' + response.data.message + '</p>';
                }
            } catch (error) {
                console.error('載入留言時發生錯誤:', error);
                let errorMessage = '載入失敗: ';

                if (error.response) {
                    // 服務器響應了錯誤狀態碼
                    errorMessage += `HTTP ${error.response.status} - ${error.response.statusText}`;
                    if (error.response.data && error.response.data.message) {
                        errorMessage += ` (${error.response.data.message})`;
                    }
                } else if (error.request) {
                    // 請求已發出但沒有收到響應
                    errorMessage += '無法連接到服務器，請檢查服務器是否啟動';
                } else {
                    // 其他錯誤
                    errorMessage += error.message;
                }

                document.getElementById('messages-container').innerHTML = `<p style="color: red; padding: 20px; background: #ffe6e6; border-radius: 5px;">${errorMessage}</p>`;
            }
        }

        // 顯示留言列表
        function displayMessages(messages) {
            const container = document.getElementById('messages-container');

            if (messages.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #718096;">暫無留言，快來發表第一則留言吧！</p>';
                return;
            }

            const messagesHtml = messages.map(msg => `
                <div class="item" id="message-${msg.id}">
                    <div class="item-header">
                        <div class="item-title">${escapeHtml(msg.name)}</div>
                        <div class="item-meta">
                            ${msg.created_at}
                            ${msg.updated_at !== msg.created_at ? '<br><small>已編輯</small>' : ''}
                        </div>
                    </div>
                    <div class="item-content">
                        ${msg.email ? `<p><strong>Email:</strong> ${escapeHtml(msg.email)}</p>` : ''}
                        <p>${escapeHtml(msg.message).replace(/\n/g, '<br>')}</p>
                    </div>
                    <div class="item-actions">
                        <button onclick="editMessage(${msg.id})" class="btn btn-warning">編輯</button>
                        <button onclick="deleteMessage(${msg.id})" class="btn btn-danger">刪除</button>
                    </div>
                </div>
            `).join('');

            container.innerHTML = messagesHtml;
        }

        // 編輯留言
        async function editMessage(id) {
            try {
                const response = await axios.get(`/api/messages/${id}`);

                if (response.data.code === 200) {
                    const message = response.data.data;

                    // 填充表單
                    document.getElementById('name').value = message.name;
                    document.getElementById('email').value = message.email || '';
                    document.getElementById('message').value = message.message;

                    // 設置編輯模式
                    editingMessageId = id;

                    // 更新表單標題和按鈕
                    document.querySelector('.form-section h3').innerHTML = '✏️ 編輯留言';
                    document.querySelector('button[type="submit"]').textContent = '更新留言';

                    // 滾動到表單
                    document.querySelector('.form-section').scrollIntoView({
                        behavior: 'smooth'
                    });
                } else {
                    alert('獲取留言失敗: ' + response.data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('獲取留言失敗: ' + error.message);
            }
        }

        // 刪除留言
        async function deleteMessage(id) {
            if (!confirm('確定要刪除這則留言嗎？此操作無法復原。')) {
                return;
            }

            try {
                const response = await axios.delete(`/api/messages/${id}`);

                if (response.data.code === 200) {
                    alert('留言刪除成功！');
                    loadMessages(); // 重新載入留言列表
                } else {
                    alert('刪除失敗: ' + response.data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('刪除失敗: ' + error.message);
            }
        }

        // 清空表單
        function clearForm() {
            document.getElementById('messageForm').reset();
            editingMessageId = null;

            // 恢復表單標題和按鈕
            document.querySelector('.form-section h3').innerHTML = '✍️ 發表留言';
            document.querySelector('button[type="submit"]').textContent = '發布留言';
        }

        // HTML 轉義函數
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }
    </script>
</body>

</html>