<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Db;

class DatabaseStatus extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('db:status')
            ->setDescription('Show database status and table information');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('📊 數據庫狀態檢查');
        $output->writeln('==================');

        try {
            // 檢查數據庫連接
            $this->checkConnection($output);

            // 檢查表結構
            $this->checkTables($output);

            // 檢查數據統計
            $this->checkDataStats($output);
        } catch (\Exception $e) {
            $output->writeln('❌ 檢查失敗: ' . $e->getMessage());
        }
    }

    private function checkConnection($output)
    {
        try {
            $config = config('database.connections.mysql');
            $output->writeln("🔗 數據庫連接信息:");
            $output->writeln("   主機: {$config['hostname']}:{$config['hostport']}");
            $output->writeln("   數據庫: {$config['database']}");
            $output->writeln("   用戶: {$config['username']}");
            $output->writeln("   字符集: {$config['charset']}");

            // 測試連接
            Db::query('SELECT 1');
            $output->writeln("   狀態: ✅ 連接正常");
            $output->writeln("");
        } catch (\Exception $e) {
            $output->writeln("   狀態: ❌ 連接失敗 - " . $e->getMessage());
        }
    }

    private function checkTables($output)
    {
        $output->writeln("📋 數據表信息:");

        $tables = ['messages'];

        foreach ($tables as $table) {
            try {
                $exists = Db::query("SHOW TABLES LIKE '{$table}'");
                if ($exists) {
                    $output->writeln("   {$table}: ✅ 存在");
                } else {
                    $output->writeln("   {$table}: ❌ 不存在");
                }
            } catch (\Exception $e) {
                $output->writeln("   {$table}: ❌ 檢查失敗");
            }
        }
        $output->writeln("");
    }

    private function checkDataStats($output)
    {
        $output->writeln("📈 數據統計:");

        try {
            $messageCount = Db::name('messages')->count();
            $output->writeln("   留言數量: {$messageCount}");

            // 最新留言
            $latestMessage = Db::name('messages')
                ->order('created_at', 'desc')
                ->find();
            if ($latestMessage) {
                $output->writeln("   最新留言: {$latestMessage['name']} ({$latestMessage['created_at']})");
            }
        } catch (\Exception $e) {
            $output->writeln("   統計失敗: " . $e->getMessage());
        }
    }
}
