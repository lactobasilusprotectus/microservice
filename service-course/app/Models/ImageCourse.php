<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ImageCourse
 *
 * @property int $id
 * @property int $courses_id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse whereCoursesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ImageCourse extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y M d H:m:s',
        'updated_at' => 'datetime:Y M d H:m:s',
    ];
}
