<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Arret extends Model
{
    /** @use HasFactory<\Database\Factories\ArretFactory> */
    use HasFactory;

    protected $fillable = ['commune_id', 'nom', 'latitude', 'longitude'];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function lignes(): BelongsToMany
    {
        return $this->belongsToMany(LigneTransport::class, 'ligne_arret', 'arret_id', 'ligne_transport_id')
            ->withPivot('ordre');
    }
}
