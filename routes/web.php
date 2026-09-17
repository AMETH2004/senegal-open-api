<?php

use Illuminate\Support\Facades\Route;

// Projet API pure : la racine renvoie directement vers la documentation
// interactive plutôt que la page de bienvenue Laravel par défaut.
Route::redirect('/', '/docs/api');
