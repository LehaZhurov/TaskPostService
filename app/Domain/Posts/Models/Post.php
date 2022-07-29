<?php

namespace App\Domain\Posts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 * @package App\Domain\Posts\Models
 * @property int $id - id поста 
 * @property string $title - название поста 
 * @property string|null $preview - ссылка на обложку
 * @property int $user_id - id полозователя который создал пост
 * @property int $rating - сумарынй рейтинг постам
 * @property Carbon $created_at - дата создания 
 * @property Carbon $updated_at - дата создания
 * @property Carbon $deleted_at - дата удаления
 * @property-read array voices - массив с оценками пользователей
 * @property-read array tags - теги поста
 * 
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'preview', 'text', 'user_id'];


    public function voices()
    {
        return $this->hasMany(Voice::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}
