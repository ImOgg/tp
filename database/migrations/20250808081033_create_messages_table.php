<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateMessagesTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // 創建 messages 表
        $table = $this->table('messages', [
            'id' => true,
            'primary_key' => ['id'],
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci',
            'comment' => '留言表'
        ]);
        
        $table->addColumn('name', 'string', [
                'limit' => 100,
                'null' => false,
                'comment' => '姓名'
            ])
            ->addColumn('email', 'string', [
                'limit' => 255,
                'null' => true,
                'comment' => '郵箱'
            ])
            ->addColumn('message', 'text', [
                'null' => false,
                'comment' => '留言內容'
            ])
            ->addColumn('created_at', 'timestamp', [
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP',
                'comment' => '創建時間'
            ])
            ->addColumn('updated_at', 'timestamp', [
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
                'comment' => '更新時間'
            ])
            ->addIndex(['created_at'], ['name' => 'idx_created_at'])
            ->create();
    }
}
