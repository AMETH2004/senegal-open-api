<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    /** @use HasFactory<\Database\Factories\CommuneFactory> */
    use HasFactory;

    protected $fillable = ['departement_id', 'code', 'nom', 'type', 'population', 'latitude', 'longitude'];

    protected function casts(): array
    {
        return [
            'population' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    public function arrets(): HasMany
    {
        return $this->hasMany(Arret::class);
    }
}
