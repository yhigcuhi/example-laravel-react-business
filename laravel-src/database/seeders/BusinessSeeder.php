<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\UserOperatableBusiness;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テスト事業所
        $list = [
            [
                'id' => 1,
                'name' => 'TEST事業所'
            ]
        ];
        // 事業所作成
        Business::upsert($list, ['id']);
        // ユーザー操作可能 事業所
        $list2 = [
            [
                'id' => 1,
                'user_id' => 1,
                'business_id' => 1,
                'is_operating' => true
            ]
        ];
        UserOperatableBusiness::upsert($list2, ['id']);
    }
}
