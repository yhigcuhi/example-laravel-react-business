<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // (所属)スタッフ
        // TODO:今後の開発としては従業員を検索・登録・更新管理画面作成 → 打刻 → 事業所管理系の機能（出勤簿 管理者むけとか） → 事業所登録（アカウント登録時）の順で開発
        Schema::create('staff', function (Blueprint $table) {
            // PK
            $table->id();
            // フィールド
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete(); // (所属先)事業所ID FK
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // (誰のアカウントか用)ユーザーID FK (null:招待 → 登録未完了)
            $table->string('last_name'); // 姓
            $table->string('first_name'); // 名
            $table->string('last_kana'); // セイ
            $table->string('first_kana'); // メイ
            // 登録更新日時
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            // テーブル論理名
            $table->comment('(事業所 所属)スタッフ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
