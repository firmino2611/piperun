<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $timestamps = [];

    protected $table = 'tasks';
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

    public function type ()
    {
        return $this->belongsTo(Type::class);
    }
}
