<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * Especifica quais são os campos timestamp
     * padrão do modelo
     * @var array
     */
    public $timestamps = [];

    /**
     * Especifica a tabela ao qual o model representa
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'responsible',
        'start_at',
        'end_at',
        'finish_at',
        'status',
        'user_id',
        'type_id',
    ];

    /**
     * Recupera o tipo de uma determinada tarefa
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
