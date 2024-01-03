<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

// 内部参照Enum 検索条件タイプ
enum QueryType
{
    case EQUAL; // 一致
    case NOT_EQUAL; // 不一致
    case IN; // IN句
    case NOT_IN; // NOT IN句
    case PREFIX; // 前方一致 like XXX%
    case SUFFIX; // 後方一致 like %XXX
    case INFIX; // 部分一致 like %XXX%
    case NOT_PREFIX; // 前方不一致 not like XXX%
    case NOT_SUFFIX; // 後方不一致 not like %XXX
    case NOT_INFIX; // 部分不一致 not like %XXX%
    case GREATER; // より大きい カラム > val
    case FROM; // 以上 カラム >= val
    case LESS; // より小さい カラム < val
    case TO; // 以下 カラム <= val

    /**
     * 文字列 → Enum
     * @param string $value 値文字
     * @return QueryType|null 該当の 検索条件タイプ Enum (NULL = 該当なし)
     */
    public static function valueOf(string $value = ''): ?self
    {
        // 大文字にした文字列として該当する検索条件タイプ返却
        return collect(self::cases())
            ->filter(fn (QueryType $type) => $type->name === strtoupper($value))
            ->first();
    }

    /**
     * Where句 ビルド
     * @param \Illuminate\Database\Eloquent\Builder $query 現在の検索クエリ
     * @param string $column 検索値
     * @param mixed $value 検索値
     * @return Builder Where句 ビルド結果
     */
    public function buildWhere(Builder $query, string $column, mixed $value): Builder
    {
        // Enumの値別 実行where句ビルド
        return match($this) {
            self::EQUAL => $query->where($column, $value), // 一致
            self::NOT_EQUAL => $query->whereNot($column, $value), // 不一致
            self::IN => $query->whereIn($column, explode(',', $value)), // IN句(検索値 カンマ区切り文字 →　配列へ)
            self::NOT_IN => $query->whereNotIn($column, explode(',', $value)), // NOT IN句(検索値 カンマ区切り文字 →　配列へ)
            self::PREFIX => $query->where($column, 'like', "$value%"), // 前方一致 like XXX%
            self::SUFFIX => $query->where($column, 'like', "%$value"), // 後方一致 like %XXX
            self::INFIX => $query->where($column, 'like', "%$value%"), // 部分一致 like %XXX%
            self::NOT_PREFIX => $query->whereNot($column, 'like', "$value%"), // 前方不一致 not like XXX%
            self::NOT_SUFFIX => $query->whereNot($column, 'like', "%$value"), // 後方不一致 not like %XXX
            self::NOT_INFIX => $query->whereNot($column, 'like', "%$value%"), // 部分不一致 not like %XXX%
            self::GREATER => $query->where($column, '>', $value), // より大きい カラム > val
            self::FROM => $query->where($column, '>=', $value), // 以上 カラム >= val
            self::LESS => $query->where($column, '<', $value), // より小さい カラム < val
            self::TO => $query->where($column, '<=', $value), // 以下 カラム <= val
        };
    }
}

/**
 * 独自 共通 検索条件 生成器 クラス
 */
abstract readonly class MyQueryBuilder
{
    // 検索項目一覧
    private array $columns;
    /**
     * フィールド指定 コンストラクタ
     * @param array $columns 検索項目 一覧
     */
    public function __construct(array $colmuns = []){}

    /**
     * 検索Query 生成
     * @param array $conditons 生成内容 検索条件 (key(検索項目) = val の連想配列の形)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function build(?array $conditions = []): Builder
    {
        return (new static)->buildQuery($conditions);
    }

    /**
     * 検索Query 生成
     * @param array $conditons 生成内容 検索条件 (key(検索項目) = val の連想配列の形)
     * @return \Illuminate\Database\Eloquent\Builder 検索条件
     */
    public function buildQuery(?array $conditions = []): Builder
    {
        // 検索query 初期化
        $query = $this->newQuery();

        // 生成内容 検索条件の各項目別に 検索条件付与
        collect($conditions)->each(function ($val, $key) use($query) {
            // 検索条件キー文字列 → 検索対象のカラム 検索 例: key = business_id → business_id, key = business_id_in → business_id
            $column = $this->findColumn($key);
            // 検索対象のカラム 指定以外の 検索条件キー文字列 → 後続処理しない
            if (!$column) return true;

            // 検索条件キー文字列 から 検索対象のカラム除いた文字列 → 検索条件タイプ (空文字:'EQUAL'補完)
            $queryType = str_ireplace($column, '', $key) | 'EQUAL';
            // 検索条件タイプ 補完
            $queryType = preg_replace('/^\_/u', '', $queryType, 1); // key = business_id_in, column = [business_id, user_id] → '_in'(in句指定) → 'in' へ

            // 検索条件タイプ による クエリ ビルド実行
            (QueryType::valueOf($queryType) ?? QueryType::EQUAL)->buildWhere($query, $column, $val);
        });

        // ビルド結果 返却
        return $query;
    }

    /**
     * 検索条件キー文字列 から 検索対象のカラム 抽出
     * @param string $key 検索条件キー
     * @return string|null 検索対象のカラム(NULL:見つからない)
     */
    private function findColumn(string $key): ?string
    {
        // 検索項目(カラム) 分 前方文字の一致数最大の カラム名抽出
        return collect($this->columns) // 検索項目(カラム) 分
            ->filter(fn ($column) => strpos($key, $column) !== false) // 検索条件キー に 前方文字の一致する カラムで
            ->sortByDesc(fn ($colmun) => strlen($colmun)) // 一致数最大(カラム文字数 最大)
            ->first(); // 見つからなければ そのまま
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder EloquentのクエリBuilder初期化
     */
    protected abstract function newQuery(): Builder;
}
