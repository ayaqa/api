<?php

namespace AyaQA\Models\Playground;

use Illuminate\Database\Eloquent\Model;

/**
 * AyaQA\Models\Playground\Toggle
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Toggle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Toggle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Toggle query()
 * @mixin \Eloquent
 */
class Toggle extends Model
{
    public const TABLE_NAME = 'toggles';

    protected $table = self::TABLE_NAME;
    protected $connection = 'tenant';
}
