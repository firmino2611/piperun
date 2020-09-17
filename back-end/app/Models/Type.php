<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para armazenamento em massa
     * @var string[]
     */
    protected $fillable = ['name', 'user_id'];

    /**
     * Recupera todas as tarefas vinculadas ao tipo
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
