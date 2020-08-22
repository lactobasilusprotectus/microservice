<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mentor
 *
 * @property int $id
 * @property string $name
 * @property string $profile
 * @property string $email
 * @property string $profession
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mentor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mentor extends Model
{
    protected $guarded = [];
    protected $casts = [
      'created_at' => 'datetime:Y M d H:m:s',
      'updated_at' => 'datetime:Y M d H:m:s',
    ];
}
