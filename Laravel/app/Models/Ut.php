<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ut extends Model
{
    protected $table = 'ut';

    protected $primaryKey = 'azon';

    public $timestamps = false;

    protected $fillable = [
        'nev',
        'hossz',
        'allomas',
        'ido',
        'vezetes',
        'telepulesid',
    ];

    protected function casts(): array
    {
        return [
            'hossz' => 'decimal:2',
            'allomas' => 'integer',
            'ido' => 'decimal:2',
            'vezetes' => 'boolean',
        ];
    }

    public function telepules(): BelongsTo
    {
        return $this->belongsTo(Telepules::class, 'telepulesid');
    }
}