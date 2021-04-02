<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MyCourse
 *
 * @property int $id
 * @property int $courses_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse whereCoursesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCourse whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Course $courses
 */
class MyCourse extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y M d H:m:s',
        'updated_at' => 'datetime:Y M d H:m:s',
    ];

    public function courses(){
        return $this->belongsTo(Course::class);
    }
}
