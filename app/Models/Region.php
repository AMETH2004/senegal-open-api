<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    /** @use HasFactory<\Database\Factories\RegionFactory> */
    use HasFactory;

    protected $fillable = ['code', 'nom', 'chef_lieu', 'superficie_km2', 'population'];

    protected function casts(): array
    {
        return [
            'superficie_km2' => 'integer',
            'population' => 'integer',
        ];
    }

    public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }

    public function densite(): float
    {
        return round($this->population / $this->superficie_km2, 1);
    }
}
