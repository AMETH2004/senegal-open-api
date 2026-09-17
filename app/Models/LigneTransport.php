<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LigneTransport extends Model
{
    /** @use HasFactory<\Database\Factories\LigneTransportFactory> */
    use HasFactory;

    protected $table = 'lignes_transport';

    protected $fillable = ['operateur_id', 'numero', 'nom', 'origine_commune_id', 'destination_commune_id'];

    public function operateur(): BelongsTo
    {
        return $this->belongsTo(OperateurTransport::class, 'operateur_id');
    }

    public function origineCommune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'origine_commune_id');
    }

    public function destinationCommune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'destination_commune_id');
    }

    public function arrets(): BelongsToMany
    {
        return $this->belongsToMany(Arret::class, 'ligne_arret', 'ligne_transport_id', 'arret_id')
            ->withPivot('ordre')
            ->orderBy('ligne_arret.ordre');
    }
}
