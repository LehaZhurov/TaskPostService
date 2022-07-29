<?php

namespace App\Domain\Posts\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 * @package App\Domain\Posts\Models
 * @property int $id - id тега
 * @property string $tag - названи тега 
 * @property Carbon $created_at - дата создания 
 * @property Carbon $updated_at - дата создания
 * @property Carbon $deleted_at - дата удаления
 * 
 */

class Tag extends Model
{
    use HasFactory;
}
