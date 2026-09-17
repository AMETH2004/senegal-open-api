<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperateurTransport extends Model
{
    /** @use HasFactory<\Database\Factories\OperateurTransportFactory> */
    use HasFactory;

    protected $table = 'operateurs_transport';

    protected $fillable = ['nom', 'slug', 'type', 'description'];

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneTransport::class, 'operateur_id');
    }
}
