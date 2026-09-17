<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    /** @use HasFactory<\Database\Factories\DepartementFactory> */
    use HasFactory;

    protected $fillable = ['region_id', 'code', 'nom', 'chef_lieu', 'population'];

    protected function casts(): array
    {
        return ['population' => 'integer'];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
}
