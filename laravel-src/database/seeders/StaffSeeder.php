<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 開発時
        if (app()->isLocal()) {
            // テスト従業員
            $list = [
                [
                    'id' => 1,
                    'business_id' => 1,
                    'user_id' => 1,
                    'last_name' => 'テスト',
                    'first_name' => '太郎',
                ]
            ];
            // 従業員作成
            Staff::upsert($list, ['id']);
        }
    }
}
