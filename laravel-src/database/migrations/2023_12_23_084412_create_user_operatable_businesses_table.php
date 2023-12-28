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
        // ユーザー 操作可能 事業所管理
        Schema::create('user_operatable_businesses', function (Blueprint $table) {
            // PK
            $table->id();
            // フィールド
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // (FK) ユーザーID (誰が)
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete(); // (FK) (操作先 所属)事業所ID (どこの)
            $table->boolean('is_operating')->default(false); // 操作中(TRUE:(所属先 事業所 1つだけ になった →　強制TRUE) /FALSE:それ以外) → 最終操作事業所
            // 登録更新日時
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            // 複合ユニークキー
            // テーブル論理名
            $table->comment('ユーザー 操作可能 事業所');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_business_permissions');
    }
};
