<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Telepules extends Model
{
    protected $table = 'telepules';

    public $timestamps = false;

    public function np(): BelongsTo
    {
        return $this->belongsTo(Np::class, 'npid');
    }

    public function utak(): HasMany
    {
        return $this->hasMany(Ut::class, 'telepulesid');
    }
}