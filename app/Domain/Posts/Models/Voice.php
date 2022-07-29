<?php

namespace App\Domain\Posts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 * @package App\Domain\Posts\Models
 * @property int $id - id голоса 
 * @property int $voices - лайк(1) или дизлайк(-1)
 * @property int $user_id - полозоватлье который проголосовал
 * @property int $post_id - пост за который проголосовал пользователь
 * @property Carbon $created_at - дата создания 
 * @property Carbon $updated_at - дата создания
 * @property Carbon $deleted_at - дата удаления   
 */

class Voice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['voices', 'user_id', 'post_id'];
    protected $dates = ['deleted_at'];
}
