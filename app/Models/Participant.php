<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Participant extends Model
{
    use HasFactory;
    use HashableId;

    protected $table = "participants";

    protected $fillable = [
        'name',
        'role',
        'identity',
        'administration_id',
    ];

    public function administration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Administration::class);
    }
}
