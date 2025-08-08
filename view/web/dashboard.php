<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ThinkPHP</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Microsoft YaHei', Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
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
        
        .card { 
            background: #f8f9ff; 
            padding: 25px; 
            margin: 20px 0; 
            border-radius: 10px; 
            border-left: 5px solid #667eea; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .card p {
            margin: 10px 0;
            color: #555;
        }
        .card strong {
            color: #667eea;
        }
        .card ul {
            margin: 15px 0;
            padding-left: 20px;
        }
        .card li {
            margin: 8px 0;
            color: #555;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-top: 4px solid #667eea;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        .stat-label {
            color: #666;
            font-size: 0.9em;
        }
        
        /* 響應式設計 */
        @media (max-width: 768px) {
            .container { padding: 15px; }
            .header h1 { font-size: 2em; }
            .nav a { margin: 5px; padding: 8px 16px; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 ThinkPHP Dashboard</h1>
            <p>歡迎來到 ThinkPHP 8 管理系統</p>
        </div>
        
        <div class="nav">
            <a href="/web/dashboard" class="active">Dashboard</a>
            <a href="/web/messages">留言板</a>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">📊</div>
                <div class="stat-label">系統監控</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">💬</div>
                <div class="stat-label">留言管理</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">🔧</div>
                <div class="stat-label">系統工具</div>
            </div>
        </div>
        
        <div class="card">
            <h3>📊 系統資訊</h3>
            <p><strong>框架版本:</strong> <?= $version ?></p>
            <p><strong>PHP 版本:</strong> <?= $php_version ?></p>
            <p><strong>當前時間:</strong> <?= $current_time ?></p>
            <p><strong>管理員:</strong> <?= $user['name'] ?></p>
        </div>
        
        <div class="card">
            <h3>🔗 快速操作</h3>
            <p>
                <a href="/web/messages" style="color: #667eea; text-decoration: none; margin-right: 20px;">💬 留言板</a>
                <a href="/api/messages" style="color: #667eea; text-decoration: none;" target="_blank">🔌 留言 API</a>
            </p>
        </div>
        
        <div class="card">
            <h3>📝 系統狀態</h3>
            <ul>
                <?php foreach ($activities as $activity): ?>
                    <li><?= $activity ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>