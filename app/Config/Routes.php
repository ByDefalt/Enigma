<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Accueil::afficher');




use App\Controllers\Accueil;

$routes->get('accueil/afficher', [Accueil::class, 'afficher']);


use App\Controllers\Compte;

$routes->get('compte/lister', [Compte::class, 'lister']);
$routes->get('compte/creer', [Compte::class, 'creer']); 
$routes->post('compte/creer', [Compte::class, 'creer']);

$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);

$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);
$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']);

$routes->get('compte/modifier_mdp', [Compte::class, 'modifier_mdp']);
$routes->post('compte/modifier_mdp', [Compte::class, 'modifier_mdp']);

use App\Controllers\Actualite;

$routes->get('actualite/afficher', [Actualite::class, 'afficher']);
$routes->get('actualite/afficher/(:num)', [Actualite::class, 'afficher']);

use App\Controllers\Scenario;

$routes->get('scenario/afficher', [Scenario::class,'afficher']);
$routes->get('scenario/afficher_etape_1', [Scenario::class,'afficher_etape_1']);
$routes->get('scenario/afficher_etape_1/(:alphanum)', [Scenario::class,'afficher_etape_1']);
$routes->get('scenario/afficher_etape_1/(:alphanum)/(:num)', [Scenario::class, 'afficher_etape_1']);

$routes->get('scenario/afficher_gestion', [Scenario::class,'afficher_gestion']);
