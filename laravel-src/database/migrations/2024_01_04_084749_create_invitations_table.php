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
        // (事業所) 招待管理 (事業所 - 従業員, 士業)
        Schema::create('invitations', function (Blueprint $table) {
            // PK
            $table->id();
            // フィールド
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete(); // (どこの) 事業所ID FK
            $table->string('email'); // (誰への) メアド (従業員のメアド変更 → 更新しない) FK
            $table->string('name')->nullable(); // (誰への) 画面表示名
            $table->string('invitation_token', 100)->unique(); // 招待トークン(招待コード) (招待 承認(アカウント作成)と DB紐付け)
            $table->timestamp('verified_at')->nullable(); // 招待 初回認証された日時 (NULL:未承認 / 値あり:承認済み)
            // 登録更新日時
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            // index
            $table->index('email');
            $table->index('invitation_token');
            // テーブル論理名
            $table->comment('(事業所) 招待管理 (事業所 - 従業員, 士業)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
