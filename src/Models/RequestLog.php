<?php

namespace CrixuAMG\RouteLogger\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RequestLog extends Model
{
    /**
     * The attributes that are illegal to save to the database.
     *
     * @var array
     */
    private static $illegalFields = [
        'client_id',
        'client_secret',
        'password',
        'password_confirmation',
    ];
    /**
     * @var array
     */
    protected $casts = [
        'parameters' => 'object',
        'query'      => 'object',
        'extra_data' => 'object',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'uri',
        'method',
        'parameters',
        'query',
        'ip',
        'user_agent',
        'query_count',
        'response_time',
        'response_code',
        'extra_data',
    ];
    /**
     * @var string
     */
    protected $table = 'request_logs';

    /**
     * @return array;
     */
    public static function getIllegalFields(): array
    {
        // Merge the data in the illegal fields array above with the configurable array in the config file
        return array_merge(
            (array)config('route-logger.log_except'),
            self::$illegalFields
        );
    }

    /**
     * query scope nPerGroup
     *
     * @return void
     */
    public function scopeNPerGroup($query, $group, $n = 10)
    {
        // queried table
        $table = ($this->getTable());

        // initialize MySQL variables inline
        $query->from(DB::raw("(SELECT @rank:=0, @group:=0) as vars, {$table}"));

        // if no columns already selected, let's select *
        if (!$query->getQuery()->columns) {
            $query->select("{$table}.*");
        }

        // make sure column aliases are unique
        $groupAlias = 'group_' . md5(time());
        $rankAlias  = 'rank_' . md5(time());

        // apply mysql variables
        $query->addSelect(DB::raw(
            "@rank := IF(@group = {$group}, @rank+1, 1) as {$rankAlias}, @group := {$group} as {$groupAlias}"
        ));

        // make sure first order clause is the group order
        $query->getQuery()->orders = (array)$query->getQuery()->orders;
        array_unshift($query->getQuery()->orders, ['column' => $group, 'direction' => 'asc']);

        // prepare subquery
        $subQuery = $query->toSql();

        // prepare new main base Query\Builder
        $newBase = $this->newQuery()
            ->from(DB::raw("({$subQuery}) as {$table}"))
            ->mergeBindings($query->getQuery())
            ->where($rankAlias, '<=', $n)
            ->getQuery();

        // replace underlying builder to get rid of previous clauses
        $query->setQuery($newBase);

        return $query;
    }
}
