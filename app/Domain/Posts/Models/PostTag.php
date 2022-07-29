<?php

namespace App\Domain\Posts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * 
 * @package App\Domain\Posts\Models
 * @property int $id - id строки
 * @property int $post_id - id поста 
 * @property int $tag_id - id тега 
 * 
 */

class PostTag extends Model
{
    use HasFactory;
}
