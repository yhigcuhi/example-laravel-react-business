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
        // 従業員 招待管理
        Schema::create('staff_invitations', function (Blueprint $table) {
            // PK
            $table->id();
            // フィールド
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete(); // (誰への) 従業員ID FK
            $table->foreignId('invitation_id')->constrained('invitations')->cascadeOnDelete(); // (どの) 招待ID FK
            // 登録更新日時
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            // テーブル論理名
            $table->comment('従業員 招待管理');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_invitations');
    }
};
