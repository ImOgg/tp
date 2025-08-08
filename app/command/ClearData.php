<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Db;

class ClearData extends Command
{
    protected function configure()
    {
        // 指令設定
        $this->setName('db:clear')
            ->setDescription('Clear all data from messages table')
            ->addArgument('table', null, 'Table name to clear (messages|all)', 'all');
    }

    protected function execute(Input $input, Output $output)
    {
        $table = $input->getArgument('table');
        
        $output->writeln('🗑️  清空資料操作');
        $output->writeln('================');

        // 確認操作
        if (!$this->confirm($output, "確定要清空 {$table} 的資料嗎？此操作不可復原！")) {
            $output->writeln('操作已取消');
            return;
        }

        try {
            switch ($table) {
                case 'messages':
                case 'all':
                    $this->clearMessages($output);
                    break;
                default:
                    $output->writeln('❌ 無效的表名，請使用: messages 或 all');
                    return;
            }
            
            $output->writeln('🎉 資料清空完成！');
        } catch (\Exception $e) {
            $output->writeln('❌ 清空失敗: ' . $e->getMessage());
        }
    }

    private function clearMessages($output)
    {
        $count = Db::name('messages')->count();
        Db::name('messages')->delete(true);
        $output->writeln("✅ 清空留言表，刪除了 {$count} 筆記錄");
    }

    private function confirm($output, $question)
    {
        $output->write($question . ' (y/N): ');
        $handle = fopen('php://stdin', 'r');
        $response = trim(fgets($handle));
        fclose($handle);
        
        return strtolower($response) === 'y' || strtolower($response) === 'yes';
    }
}