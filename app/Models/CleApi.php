<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CleApi extends Model
{
    /** @use HasFactory<\Database\Factories\CleApiFactory> */
    use HasFactory;

    protected $table = 'cles_api';

    protected $fillable = ['email', 'nom_application', 'cle_hash', 'suffixe', 'actif', 'nombre_requetes', 'dernier_acces_at'];

    protected function casts(): array
    {
        return [
            'actif' => 'boolean',
            'dernier_acces_at' => 'datetime',
        ];
    }

    /**
     * Génère une nouvelle clé API en clair et l'enregistrement associé (seul
     * son hash SHA-256 est persisté, la valeur en clair n'est jamais
     * récupérable après cet appel — comme un jeton Sanctum).
     *
     * @return array{cle: string, enregistrement: self}
     */
    public static function generer(string $email, ?string $nomApplication = null): array
    {
        $cle = 'sen_'.Str::random(40);

        $enregistrement = self::create([
            'email' => $email,
            'nom_application' => $nomApplication,
            'cle_hash' => hash('sha256', $cle),
            'suffixe' => substr($cle, -6),
        ]);

        return ['cle' => $cle, 'enregistrement' => $enregistrement];
    }

    public static function trouverParCle(string $cle): ?self
    {
        return self::where('cle_hash', hash('sha256', $cle))->first();
    }
}
