<?php

namespace AyaQA\Models\Core;

use Illuminate\Database\Eloquent\Model;

/**
 * AyaQA\Models\Core\Bug
 *
 * @method static \Spatie\Multitenancy\TenantCollection|static[] all($columns = ['*'])
 * @method static \Spatie\Multitenancy\TenantCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Bug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bug query()
 * @mixin \Eloquent
 */
class Bug extends Model
{
    public const TABLE_NAME = 'bugs';

    protected $table = self::TABLE_NAME;
    protected $connection = 'tenant';

    protected $fillable = ['target', 'applicable', 'bug', 'bugConfig', 'condition', 'conditionConfig'];

    protected $casts = [
        'bugConfig' => 'array',
        'conditionConfig' => 'array',
    ];
}
