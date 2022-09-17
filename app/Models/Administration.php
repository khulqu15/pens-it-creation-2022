<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Administration extends Model
{
    use HasFactory;
    use HashableId;

    protected $table = 'administrations';

    protected $fillable = [
        'name',
        'instance',
        'category',
        'user_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participant(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function elimination(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Elimination::class);
    }
}
