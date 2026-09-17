# SenegalOpenAPI — API publique open data (démographie & transport)

API REST documentée (OpenAPI/Swagger interactif) exposant le découpage
administratif du Sénégal (régions, départements, communes) et le réseau de
transport urbain de Dakar (opérateurs, lignes, arrêts), avec un lien direct
entre les deux domaines : chaque arrêt est rattaché à une commune.

Ce projet sert de démonstration de conception d'API propre : versionnage,
pagination/tri/filtrage standardisés, validation via Form Requests
auto-documentée, authentification par clé API, limitation de débit, et
documentation OpenAPI générée automatiquement depuis le code (pas
d'annotations à maintenir à la main).

- **API REST Laravel 12**, SQLite
- **Documentation interactive** : [dedoc/scramble](https://scramble.dedoc.co/) (Swagger UI / OpenAPI 3.1), générée depuis les routes, Form Requests et API Resources — zéro annotation manuelle à synchroniser

## Prérequis

PHP 8.3+, Composer.

## Démarrage

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed     # régions, départements, communes, transport + 1 clé API de démo
php artisan serve              # http://127.0.0.1:8000 (redirige vers /docs/api)
```

La documentation interactive est servie sur `/docs/api` (Swagger UI /
Stoplight Elements) et le schéma brut sur `/docs/api.json`.

## Authentification par clé API

Toutes les routes de données exigent une clé API dans l'en-tête
`X-API-Key`. Aucune n'est requise pour créer une clé ou consulter
`/v1/sante`.

```bash
# 1. Obtenir une clé (la valeur en clair n'est montrée qu'une fois)
curl -X POST http://127.0.0.1:8000/api/v1/cles-api \
  -H "Content-Type: application/json" \
  -d '{"email":"vous@example.com","nom_application":"Mon app"}'

# 2. L'utiliser
curl http://127.0.0.1:8000/api/v1/regions \
  -H "X-API-Key: sen_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
```

Clé de démonstration prête à l'emploi après le seed :
`sen_demo_cle_publique_de_demonstration`.

Seul le hash SHA-256 de chaque clé est stocké (comme un jeton Sanctum) — la
valeur en clair n'est jamais récupérable après sa création. Limite : **60
requêtes/minute par clé** (en-têtes `X-RateLimit-*` sur chaque réponse,
`429` + `Retry-After` au-delà).

## Ressources principales

| Ressource | Endpoints |
|---|---|
| Régions | `GET /v1/regions`, `GET /v1/regions/{code}`, `GET /v1/regions/{code}/departements` |
| Départements | `GET /v1/departements`, `GET /v1/departements/{code}`, `GET /v1/departements/{code}/communes` |
| Communes | `GET /v1/communes`, `GET /v1/communes/{code}`, `GET /v1/communes/{code}/arrets` |
| Opérateurs de transport | `GET /v1/operateurs-transport`, `GET /v1/operateurs-transport/{slug}` |
| Lignes de transport | `GET /v1/lignes-transport`, `GET /v1/lignes-transport/{id}`, `GET /v1/lignes-transport/{id}/arrets` |
| Arrêts | `GET /v1/arrets`, `GET /v1/arrets/{id}` |

Toutes les listes acceptent `per_page` (max 100) et la plupart un `sort`
(`champ` ou `-champ` pour décroissant) ainsi que des filtres dédiés (voir
Swagger pour le détail exact par ressource — région, type, nom, population
minimale...). Les réponses paginées suivent le format standard des
ressources API Laravel (`data` / `links` / `meta`).

## Provenance des données

- **Découpage administratif** (régions, départements) : noms et
  rattachements réels (14 régions, 46 départements). Les superficies
  régionales sont des valeurs de référence usuelles. **Les populations
  (région/département/commune) sont des estimations indicatives à but de
  démonstration**, pas des chiffres officiels du dernier recensement ANSD.
- **Réseau de transport** (opérateurs, lignes, arrêts) : données
  d'exemple librement inspirées de la géographie réelle de Dakar (quartiers,
  coordonnées approximatives) et des opérateurs réellement en activité
  (Dakar Dem Dikk, AFTU). Ce n'est ni un flux GTFS officiel, ni un horaire
  réel — à but de démonstration uniquement.

## Choix d'architecture

- **Versionnage explicite** (`/api/v1/...`) dès le départ.
- **Validation = documentation** : chaque endpoint de liste utilise un
  `FormRequest` dédié (`app/Http/Requests/V1`) ; ses règles de validation
  sont à la fois ce qui valide la requête *et* ce que Scramble lit pour
  générer les paramètres OpenAPI (nom, type, description prise sur le
  commentaire au-dessus de chaque règle). Un seul endroit à maintenir.
- **Sécurité auto-documentée** : le schéma de sécurité OpenAPI
  (`X-API-Key`) et son application par route sont dérivés automatiquement
  du middleware `cle-api` réellement branché sur les routes
  (`MiddlewareAuthSecurityStrategy` de Scramble, configuré dans
  `config/scramble.php`) — la doc ne peut pas se désynchroniser du code.
- **Tri en liste blanche** : `Controller::appliquerTri()` n'autorise que
  les colonnes explicitement déclarées par chaque contrôleur, pour éviter
  d'exposer un tri sur une colonne arbitraire de la table.
- **Pagination bornée** : `per_page` est plafonné à 100 partout.
- **Lien inter-domaines** : `GET /v1/communes/{code}/arrets` illustre la
  relation entre démographie et transport (un arrêt appartient à une
  commune).

## Aller plus loin

En production, `APP_DEBUG` doit être à `false` (les réponses d'erreur
incluent sinon la trace complète) et un `Gate::define('viewApiDocs', ...)`
doit être ajouté si l'accès à `/docs/api` doit être restreint hors
environnement local (voir `RestrictedDocsAccess` de Scramble).
