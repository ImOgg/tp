# ThinkPHP 8 留言板系統

基於 ThinkPHP 8 框架開發的簡潔留言板系統，支持留言的增刪改查功能。

## 🚀 功能特點

- **現代化界面** - 響應式設計，支持桌面和移動端
- **完整 CRUD** - 支持留言的創建、讀取、更新、刪除
- **RESTful API** - 提供完整的 API 接口
- **實時更新** - 操作後自動刷新列表
- **數據驗證** - 完善的表單驗證和錯誤處理
- **Migration 支持** - 使用官方 Migration 工具管理數據庫

## 📋 系統要求

- PHP >= 8.0
- MySQL >= 5.7
- Composer

### 核心依賴包

| 依賴包 | 版本 | 用途 |
|--------|------|------|
| `topthink/framework` | ^8.0 | ThinkPHP 核心框架 |
| `topthink/think-orm` | ^3.0\|^4.0 | 數據庫 ORM 組件 |
| `topthink/think-template` | ^3.0 | 模板引擎組件 |
| `topthink/think-migration` | ^3.1 | 數據庫遷移工具 |
| `topthink/think-filesystem` | ^2.0\|^3.0 | 文件系統組件 |

## 🛠️ 安裝步驟

### 1. 克隆項目
```bash
git clone <repository-url>
cd tp
```

### 2. 安裝依賴
```bash
composer install
```

### 2.1 安裝額外依賴（如果需要）
如果 composer.json 中沒有包含以下依賴，請手動安裝：

```bash
# ORM 支持（數據庫操作）
composer require topthink/think-orm

# 模板引擎支持
composer require topthink/think-template

# Migration 支持（數據庫遷移）
composer require topthink/think-migration
```

**依賴說明：**
- `topthink/think-orm` - ThinkPHP ORM 組件，用於數據庫操作
- `topthink/think-template` - 模板引擎，用於視圖渲染
- `topthink/think-migration` - 數據庫遷移工具，用於管理數據庫結構變更

### 3. 配置數據庫
編輯 `.env` 文件：
```env
APP_DEBUG = true

DB_TYPE = mysql
DB_HOST = 127.0.0.1
DB_NAME = tp
DB_USER = root
DB_PASS = 
DB_PORT = 3306
DB_CHARSET = utf8mb4

DEFAULT_LANG = zh-tw
```

**語言設定說明：**
- `DEFAULT_LANG = zh-tw` - 設定為台灣繁體中文
- 如需使用簡體中文，可改為 `zh-cn`
- HTML 模板已設定為 `lang="zh-TW"`

### 4. 初始化數據庫
```bash
# 執行 Migration 創建數據表
php think migrate:run

# 運行 Seeder 插入測試數據
php think seed:run
```

**注意：** 項目已包含以下文件：
- `database/migrations/` - 留言表的 Migration 文件
- `database/seeds/MessageSeeder.php` - 測試數據的 Seeder 文件

### 5. 啟動服務器
```bash
php think run
```

訪問 `http://localhost:8000` 即可使用系統。

## 📱 頁面介紹

### 主要頁面

| 頁面 | URL | 描述 |
|------|-----|------|
| 儀表板 | `/web/dashboard` | 系統概覽和快速操作 |
| 留言板 | `/web/messages` | 留言的發布、查看、編輯、刪除 |

### API 接口

| 方法 | URL | 描述 |
|------|-----|------|
| GET | `/api/` | API 基本信息 |
| GET | `/api/messages` | 獲取留言列表 |
| POST | `/api/messages` | 創建新留言 |
| GET | `/api/messages/{id}` | 獲取單條留言 |
| PUT | `/api/messages/{id}` | 更新留言 |
| DELETE | `/api/messages/{id}` | 刪除留言 |
| GET | `/health` | 健康檢查 |

## 🎯 使用方法

### Web 界面操作

1. **發表留言**
   - 訪問 `/web/messages`
   - 填寫姓名、Email（可選）、留言內容
   - 點擊「發布留言」

2. **編輯留言**
   - 在留言列表中點擊「編輯」按鈕
   - 修改內容後點擊「更新留言」

3. **刪除留言**
   - 在留言列表中點擊「刪除」按鈕
   - 確認刪除操作

### API 使用示例

#### 獲取留言列表
```bash
curl -X GET http://localhost:8000/api/messages
```

#### 創建留言
```bash
curl -X POST http://localhost:8000/api/messages \
  -H "Content-Type: application/json" \
  -d '{
    "name": "張三",
    "email": "zhang@example.com",
    "message": "這是一則測試留言"
  }'
```

#### 更新留言
```bash
curl -X PUT http://localhost:8000/api/messages/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "張三",
    "email": "zhang@example.com",
    "message": "這是更新後的留言"
  }'
```

#### 刪除留言
```bash
curl -X DELETE http://localhost:8000/api/messages/1
```

## 🗄️ 數據庫管理

### 內建命令

```bash
# 檢查數據庫狀態（自定義命令）
php think db:status

# 清空留言數據（自定義命令）
php think db:clear
```

### Migration 管理

使用官方 `topthink/think-migration` 工具：

```bash
# 創建新的 Migration
php think migrate:create CreateUsersTable

# 執行 Migration
php think migrate:run

# 回滾 Migration
php think migrate:rollback

# 查看 Migration 狀態
php think migrate:status

# 創建 Seeder（數據填充）
php think seed:create UserSeeder

# 運行 Seeder
php think seed:run
```

**Migration 文件示例：**
```php
<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUsersTable extends Migrator
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 255])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}
```

### 數據表結構

#### messages 表
| 欄位 | 類型 | 描述 |
|------|------|------|
| id | int(11) | 主鍵，自增 |
| name | varchar(100) | 留言者姓名 |
| email | varchar(255) | 留言者郵箱（可選） |
| message | text | 留言內容 |
| created_at | timestamp | 創建時間 |
| updated_at | timestamp | 更新時間 |

## 🏗️ 項目結構

```
tp/
├── app/
│   ├── controller/          # 控制器
│   │   ├── Index.php       # 首頁控制器
│   │   ├── Message.php     # 留言 API 控制器
│   │   └── Web.php         # Web 頁面控制器
│   ├── model/              # 模型
│   │   └── Message.php     # 留言模型
│   └── command/            # 自定義命令
│       ├── InitDatabase.php
│       ├── DatabaseStatus.php
│       └── ClearData.php
├── config/                 # 配置文件
├── route/                  # 路由定義
│   ├── app.php            # Web 路由
│   └── api.php            # API 路由
├── view/                   # 視圖模板
│   └── web/
│       ├── dashboard.php   # 儀表板
│       └── admin.php       # 留言板
├── database/               # 數據庫相關
├── .env                    # 環境配置
└── README.md              # 項目說明
```

## 🎨 技術特點

### 前端技術
- **Axios** - HTTP 請求庫
- **響應式 CSS** - 支持各種設備
- **現代化 UI** - 漸變背景、卡片設計
- **JavaScript ES6+** - 現代 JavaScript 語法

### 後端技術
- **ThinkPHP 8** - PHP 框架核心
- **think-orm** - 數據庫 ORM 組件，支持模型關聯、查詢構造器
- **think-template** - 模板引擎，支持模板繼承、標籤語法
- **think-migration** - 數據庫遷移工具，支持版本控制
- **RESTful API** - 標準 API 設計
- **驗證器** - 數據驗證和過濾

### 安全特性
- **HTML 轉義** - 防止 XSS 攻擊
- **數據驗證** - 服務端數據驗證
- **錯誤處理** - 完善的錯誤處理機制

## 🔧 開發工具

### 有用的命令

#### 基本命令
```bash
# 查看所有可用命令
php think

# 查看路由列表
php think route:list

# 清理緩存
php think clear

# 啟動開發服務器
php think run
```

#### 代碼生成命令
```bash
# 創建控制器
php think make:controller UserController

# 創建模型
php think make:model User

# 創建中間件
php think make:middleware Auth

# 創建驗證器
php think make:validate UserValidate

# 創建服務類
php think make:service UserService
```

#### Migration 和 Seeder 命令
```bash
# 創建 Migration
php think migrate:create CreateUsersTable

# 執行 Migration
php think migrate:run

# 回滾 Migration
php think migrate:rollback

# 創建 Seeder
php think seed:create UserSeeder

# 運行 Seeder
php think seed:run
```

#### 自定義數據庫命令
```bash
# 檢查數據庫狀態（自定義命令）
php think db:status

# 清空數據（自定義命令）
php think db:clear
```

### 調試技巧

1. **開啟調試模式**
   - 在 `.env` 中設置 `APP_DEBUG = true`

2. **查看錯誤日誌**
   - 檢查 `runtime/log/` 目錄下的日誌文件

3. **API 調試**
   - 使用瀏覽器 F12 控制台查看網絡請求
   - 使用 Postman 或 curl 測試 API

## 🔧 故障排除

### 常見問題

#### 1. 依賴包缺失
如果遇到類似 "Class not found" 的錯誤，請確保安裝了所有必要的依賴：

```bash
composer require topthink/think-orm
composer require topthink/think-template  
composer require topthink/think-migration
```

#### 2. 數據庫連接失敗
- 檢查 `.env` 文件中的數據庫配置
- 確保 MySQL 服務正在運行
- 驗證數據庫用戶權限

#### 3. Migration 命令不可用
如果 `php think migrate:*` 命令不存在：

```bash
# 確保安裝了 migration 組件
composer require topthink/think-migration

# 重新發現服務
php think service:discover
```

#### 4. 模板渲染錯誤
如果模板無法渲染：

```bash
# 確保安裝了模板引擎
composer require topthink/think-template

# 清理緩存
php think clear
```

#### 5. 權限問題
確保以下目錄有寫入權限：
```bash
chmod -R 755 runtime/
chmod -R 755 public/
```

## 📝 API 響應格式

### 成功響應
```json
{
  "code": 200,
  "message": "success",
  "data": {
    "messages": [
      {
        "id": 1,
        "name": "張三",
        "email": "zhang@example.com",
        "message": "這是一則留言",
        "created_at": "2025-08-08 10:00:00",
        "updated_at": "2025-08-08 10:00:00"
      }
    ],
    "total": 1,
    "page": 1,
    "limit": 10,
    "pages": 1
  },
  "timestamp": 1691472000
}
```

### 錯誤響應
```json
{
  "code": 422,
  "message": "姓名不能為空",
  "data": [],
  "timestamp": 1691472000
}
```

## 🤝 貢獻指南

1. Fork 本項目
2. 創建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 打開 Pull Request

## 📄 許可證

本項目基於 Apache-2.0 許可證開源。詳見 [LICENSE](LICENSE) 文件。

## 🙏 致謝

- [ThinkPHP](https://www.thinkphp.cn/) - 優秀的 PHP 框架
- [Axios](https://axios-http.com/) - 強大的 HTTP 客戶端
- 所有貢獻者和使用者

## 📞 聯繫方式

如有問題或建議，請通過以下方式聯繫：

- 提交 Issue
- 發送 Pull Request
- 郵箱：[your-email@example.com]

---

**享受編程的樂趣！** 🎉