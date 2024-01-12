<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

use App\Controllers\Accueil;

$routes->get('/', 'Accueil::afficher');

$routes->get('accueil/afficher', [Accueil::class, 'afficher']);

$routes->get('accueil/afficher_back', [Accueil::class, 'afficher_back']);

use App\Controllers\Compte;

$routes->get('compte/lister', [Compte::class, 'lister']);
$routes->get('compte/creer', [Compte::class, 'creer']); 
$routes->post('compte/creer', [Compte::class, 'creer']);

$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);

$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);
$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']);

$routes->get('compte/modifier', [Compte::class, 'modifier_mdp']);
$routes->post('compte/modifier', [Compte::class, 'modifier_mdp']);

use App\Controllers\Scenario;

$routes->get('scenario/afficher', [Scenario::class,'afficher']);
$routes->get('scenario/afficher_etape_1', [Scenario::class,'afficher_etape_1']);
$routes->get('scenario/afficher_etape_1/(:alphanum)', [Scenario::class,'afficher_etape_1']);
$routes->get('scenario/afficher_etape_1/(:alphanum)/(:num)', [Scenario::class, 'afficher_etape_1']);

$routes->get('scenario/afficher_gestion', [Scenario::class,'afficher_gestion']);

$routes->get('scenario/creer', [Scenario::class,'creer']);
$routes->post('scenario/creer', [Scenario::class,'creer']);

$routes->get('scenario/supprimer', [Scenario::class,'supprimer']);
$routes->post('scenario/supprimer', [Scenario::class,'supprimer']);

$routes->get('scenario/detail', [Scenario::class,'afficher_detail']);
$routes->post('scenario/detail', [Scenario::class,'afficher_detail']);

$routes->get('scenario/franchir_etape', [Scenario::class,'franchir_etape']);
$routes->post('scenario/franchir_etape', [Scenario::class,'franchir_etape']);

$routes->get('scenario/reussite', [Scenario::class,'scenario_reussite']);
$routes->post('scenario/reussite', [Scenario::class,'scenario_reussite']);