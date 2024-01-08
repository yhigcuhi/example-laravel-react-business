<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 利用スキーマ
        $schema = env('DB_DATABASE');
        // テーブル名
        $view_table_name = 'view_user_invitations';
        // (View) (ユーザー 事業所) 招待 一覧 作成
        DB::statement("DROP VIEW IF EXISTS {$schema}.{$view_table_name}");
        DB::statement("CREATE VIEW {$schema}.{$view_table_name} AS
            SELECT
                I.id
                , U.id AS user_id
                , I.id AS invitation_id
            FROM
                invitations AS I
                INNER JOIN users AS U
                    ON I.email = U.email
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
