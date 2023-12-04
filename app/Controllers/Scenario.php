<?php
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Scenario extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->model = model(Db_model::class);
    }
    public function afficher()
    {
        $model = model(Db_model::class);
        $data['titre'] = "Liste de tous les scenarios activés";
        $data['scenarios'] = $model->get_scenario_active();
        return view('templates/haut', $data)
            . view('templates/menu_visiteur.php')
            . view('affichage_scenarios.php')
            . view('templates/bas');
    }
    public function afficher_etape_1($scecode = '0', $indniveau = 0)
    {
        $model = model(Db_model::class);
        if ($scecode == "0" || $indniveau <= 0 || $indniveau > 3) {
            return redirect()->to('/scenario/afficher');
        } else {
            $data['etape'] = $model->get_etape_1($scecode, $indniveau);
        }
        return view('templates/haut', $data)
            . view('templates/menu_visiteur.php')
            . view('affichage_etape.php')
            . view('templates/bas');
    }
    public function afficher_gestion()
    {
        $session = session();
        if ($session->has('user')) {
            if ($this->model->is_admin($session->get('user')) == false) {
                $model = model(Db_model::class);
                $data['scenarios'] = $model->get_all_scenario();
                return view('templates/haut', $data)
                    . view('templates/menu_organisateur')
                    . view('gestion_scenarii.php')
                    . view('templates/bas');
            }else{
                return view('templates/haut', ['titre' => 'Se connecter'])
                . view('templates/menu_administrateur')
                . view('accueil/afficher')
                . view('templates/bas');
            }
        }else{
            return view('templates/haut', ['titre' => 'Se connecter'])
                . view('templates/menu_visiteur')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }
}