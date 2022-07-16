<?php

namespace AyaQA\Models\Playground;

use Illuminate\Database\Eloquent\Model;

/**
 * AyaQA\Models\Playground\Toggle
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox query()
 * @mixin \Eloquent
 */
class Checkbox extends Model
{
    public const TABLE_NAME = 'checkboxes';

    protected $table = self::TABLE_NAME;
    protected $connection = 'tenant';
}
