<?php

use think\migration\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '張三',
                'email' => 'zhang@example.com',
                'message' => '這是第一則留言，歡迎大家來留言！',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '李四',
                'email' => 'li@example.com',
                'message' => '網站做得不錯，繼續加油！',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => '王五',
                'email' => 'wang@example.com',
                'message' => '希望能增加更多功能～',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Alice',
                'email' => 'alice@example.com',
                'message' => 'Great message board system! Very easy to use.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bob',
                'email' => null,
                'message' => 'Thanks for creating this awesome tool!',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->table('messages')->insert($data)->save();
    }
}