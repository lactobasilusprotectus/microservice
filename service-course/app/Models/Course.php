<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $name
 * @property int $certificate
 * @property string|null $thumbnail
 * @property string $type
 * @property string $status
 * @property int|null $price
 * @property string $level
 * @property string|null $description
 * @property int $mentors_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereMentorsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chapter[] $chapters
 * @property-read int|null $chapters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ImageCourse[] $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Mentor $mentor
 */
class Course extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y M d H:m:s',
        'updated_at' => 'datetime:Y M d H:m:s',
    ];

    public function mentor(){
        return $this->belongsTo(Mentor::class, 'mentors_id');
    }

    public function chapters(){
        return $this->hasMany(Chapter::class, 'courses_id')->orderBy('id', 'ASC');
    }

    public function images(){
        return $this->hasMany(ImageCourse::class, 'courses_id')->orderBy('id', 'DESC');
    }
}
