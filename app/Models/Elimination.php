<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Elimination extends Model
{
    use HasFactory;
    use HashableId;

    protected $table = 'eliminations';

    protected $fillable = [
        'link',
        'administration_id',
    ];

    public function administration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Administration::class);
    }
}
