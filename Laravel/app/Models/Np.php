<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Np extends Model
{
    protected $table = 'np';

    public $timestamps = false;

    public function telepulesek(): HasMany
    {
        return $this->hasMany(Telepules::class, 'npid');
    }
}