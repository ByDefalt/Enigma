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
        $data['titre'] = "Liste de tous les scenarios activés";
        $data['scenarios'] = $this->model->get_scenario_active();
        $session = session();
        if ($session->has('user')) {
            if($session->get('role')=='A'){
                return view('templates/haut',$data)
                . view('templates/menu_administrateur')
                . view('affichage_scenarios')
                . view('templates/bas');
            }else{
                return view('templates/haut',$data)
                . view('templates/menu_organisateur')
                . view('affichage_scenarios')
                . view('templates/bas');
            }
        } else {
            return view('templates/haut',$data)
                . view('templates/menu_visiteur')
                . view('affichage_scenarios')
                . view('templates/bas');
        }
    }
    public function afficher_etape_1($scecode = '0', $indniveau = 0)
    {
        $session = session();
        $data['etape'] = $this->model->get_etape_1($scecode, $indniveau);
        $scenario=$this->model->get_scenario($scecode);
        if ($scecode == "0" || $indniveau <= 0 || $indniveau > 3 || !isset($scenario)) {
            $data['erreur']="L'information recherchée n'existe pas !";
        }
        if ($session->has('user')) {
            if($session->get('role')=='A'){
                return view('templates/haut',$data)
                . view('templates/menu_administrateur')
                . view('scenario/affichage_etape')
                . view('templates/bas');
            }else{
                return view('templates/haut',$data)
                . view('templates/menu_organisateur')
                . view('scenario/affichage_etape')
                . view('templates/bas');
            }
        } else {
            return view('templates/haut',$data)
                . view('templates/menu_visiteur')
                . view('scenario/affichage_etape')
                . view('templates/bas');
        }
    }
    public function afficher_gestion()
    {
        $session = session();
        if ($session->has('user')) {
            if ($session->get('role') == 'O') {
                $data['scenarios'] = $this->model->get_all_scenario();
                return view('templates/haut', $data)
                    . view('templates/menu_organisateur')
                    . view('scenario/gestion_scenarii')
                    . view('templates/bas');
            }else{
                return redirect()->to('/compte/afficher_profil');
            }
        }else{
            return redirect()->to('/compte/connecter');
        }
    }
    public function creer(){
        $session = session();
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'titre' => 'required|max_length[200]',
                        'description' => 'required|max_length[200]',
                        'active' => 'in_list[A,D]',
                        'sce_code' => 'required|exact_length[15]|is_unique[t_scenario_sce.sce_code]',
                        'fichier' => [
                            'label' => 'Fichier image',
                            'rules' => [
                            'uploaded[fichier]',
                            'is_image[fichier]',
                            'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                            'max_size[fichier,1000]',
                            ]],
                    ],
                    [
                        'titre' => [
                            'required' => 'Veuillez entrer un titre pour le scenario !'
                        ],
                        'description' => [
                            'required' => 'Veuillez entrer une description pour le scenario !',
                            'max_length'=>'Le mot de passe saisi est trop long !',
                        ],
                        'active' => [
                            'in_list' => 'Le rôle doit être soit "A" ou "O".',
                        ],
                        'sce_code' => [
                            'required' => 'Veuillez entrer un code pour le scenario !',
                            'exact_length' => 'Le code doit contenir 15 caractère.',
                            'is_unique' => 'Le code existe déjà !',
                        ],
                        'fichier' => [
                            'uploaded' => 'Veuillez télécharger un fichier.',
                            'is_image' => 'Le fichier doit être une image.',
                            'mime_in' => 'Le fichier doit être au format image (jpg, jpeg, gif, png, webp).',
                            'max_size' => 'La taille du fichier ne doit pas dépasser 1000 Ko.',
                        ]
                    ]
                )
            ) { // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut')
                        . view('templates/menu_organisateur')
                        . view('scenario/scenario_creer')
                        . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $saisie['pseudo'] = $session->get('user');
            $saisie['titre'] = $this->request->getVar('titre');
            $saisie['description'] = $this->request->getVar('description');
            $saisie['active'] = $this->request->getVar('active');
            $saisie['code'] = $this->request->getVar('sce_code');
            $fichier=$this->request->getFile('fichier');
            if(!empty($fichier)){
                $nom_fichier=$fichier->getName();
                $nouveau_nom_fichier=$saisie['code'].'_'.$nom_fichier;
                $saisie['namefile']=$nouveau_nom_fichier;
                if($fichier->move("images",$nouveau_nom_fichier)){
                    // + Mettre ici l’appel de la fonction membre du Db_model
                    // + L’affichage de la page indiquant l’ajout du compte !
                    $this->model->set_scenario($saisie);
                    return redirect()->to('/scenario/afficher_gestion');
                }
            }
        }
        if ($session->has('user')) {
            if ($session->get('role') == 'O') {
                $data['scenario']=$this->model->get_all_scenario();
                return view('templates/haut',$data)
                    . view('templates/menu_organisateur')
                    . view('scenario/scenario_creer')
                    . view('templates/bas');
            }else{
                return redirect()->to('/compte/afficher_profil');
            }
        }else{
            return redirect()->to('/compte/connecter');
        }
    }

    public function supprimer(){
        $session = session();
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'sce_code' => 'required|exact_length[15]'
                    ],[
                        'sce_code'=>[
                            'required'=>'Ne pas modifier les formulaire caché',
                            'exact_length'=>'Ne pas modifier les formulaire caché',
                        ]
                    ]
                )
            ) { // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut')
                        . view('templates/menu_organisateur')
                        . view('scenario/scenario_creer')
                        . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $saisie['pseudo'] = $session->get('user');
            $saisie['code'] = $this->request->getVar('sce_code');
            $this->model->del_scenario($saisie);
        }
        return redirect()->to('/scenario/afficher_gestion');
    }

    public function afficher_detail(){
        $session = session();
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'sce_code' => 'required|exact_length[15]'
                    ],[
                        'sce_code'=>[
                            'required'=>'Ne pas modifier les formulaire caché',
                            'exact_length'=>'Ne pas modifier les formulaire caché',
                        ]
                    ]
                )
            ) { // La validation du formulaire a échoué, retour au formulaire !
                    return view('templates/haut')
                        . view('templates/menu_organisateur')
                        . view('scenario/gestion_scenarii')
                        . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $saisie['pseudo'] = $session->get('user');
            $saisie['code'] = $this->request->getVar('sce_code');
            $data['scenarios']=$this->model->get_scenario_details($saisie);
            return view('templates/haut',$data)
                . view('templates/menu_organisateur')
                . view('scenario/scenario_detail')
                . view('templates/bas');
        }
        return redirect()->to('/scenario/afficher_gestion');
    }
    public function franchir_etape(){
        $session = session();
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'code' => 'required|exact_length[8]',
                        'reponsse'=> 'required',
                        'niv'=>'required'
                    ],[
                        'reponsse' => [
                            'required' => 'Veuillez entrer une réponsse !'
                        ],
                        'sce_code'=>[
                            'required'=>'Ne pas modifier les formulaire caché',
                            'exact_length'=>'Ne pas modifier les formulaire caché',
                        ],
                        'niv'=>[
                            'required'=>'Ne pas modifier les formulaire caché'
                        ]
                    ]
                )
            ) { // La validation du formulaire a échoué, retour au formulaire !
                $saisie['code'] = $this->request->getVar('code');
                $saisie['niv']=$this->request->getVar('niv');
                $data['etape']=$this->model->get_etape($saisie);
                     if ($session->has('user')) {
                        if($session->get('role')=='A'){
                            return view('templates/haut',$data)
                            . view('templates/menu_administrateur')
                            . view('scenario/franchir_etape')
                            . view('templates/bas');
                        }else{
                            return view('templates/haut',$data)
                            . view('templates/menu_organisateur')
                            . view('scenario/franchir_etape')
                            . view('templates/bas');
                        }
                    } else {
                        return view('templates/haut',$data)
                            . view('templates/menu_visiteur')
                            . view('scenario/franchir_etape')
                            . view('templates/bas');
                    }
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $saisie['code'] = $this->request->getVar('code');
            $saisie['reponsse'] = $this->request->getVar('reponsse');
            $saisie['niv']=$this->request->getVar('niv');
            $data['etape']=$this->model->get_etape($saisie);
            if ($saisie['niv'] <= 0 || $saisie['niv'] > 3 || !isset($data['etape'])) {
                $data['erreur2']="L'information recherchée n'existe pas !";
            }
            if($this->model->reponsse_is_valid($saisie)){
                $data['etape']=$this->model->get_next_etape($saisie);
                if ($data['etape'] == null) {
                    $data['etape']=$this->model->get_etape($saisie);
                         if ($session->has('user')) {
                            if($session->get('role')=='A'){
                                return view('templates/haut',$data)
                                . view('templates/menu_administrateur')
                                . view('scenario/scenario_reussite')
                                . view('templates/bas');
                            }else{
                                return view('templates/haut',$data)
                                . view('templates/menu_organisateur')
                                . view('scenario/scenario_reussite')
                                . view('templates/bas');
                            }
                        } else {
                            return view('templates/haut',$data)
                                . view('templates/menu_visiteur')
                                . view('scenario/scenario_reussite')
                                . view('templates/bas');
                        }
                         
                }
                if ($session->has('user')) {
                    if($session->get('role')=='A'){
                        return view('templates/haut',$data)
                        . view('templates/menu_administrateur')
                        . view('scenario/franchir_etape')
                        . view('templates/bas');
                    }else{
                        return view('templates/haut',$data)
                        . view('templates/menu_organisateur')
                        . view('scenario/franchir_etape')
                        . view('templates/bas');
                    }
                } else {
                    return view('templates/haut',$data)
                        . view('templates/menu_visiteur')
                        . view('scenario/franchir_etape')
                        . view('templates/bas');
                }

            }else{
                $data['etape']=$this->model->get_etape($saisie);
                $data['erreur']="Réponse Incorecte";
                if ($session->has('user')) {
                    if($session->get('role')=='A'){
                        return view('templates/haut',$data)
                        . view('templates/menu_administrateur')
                        . view('scenario/franchir_etape')
                        . view('templates/bas');
                    }else{
                        return view('templates/haut',$data)
                        . view('templates/menu_organisateur')
                        . view('scenario/franchir_etape')
                        . view('templates/bas');
                    }
                } else {
                    return view('templates/haut',$data)
                        . view('templates/menu_visiteur')
                        . view('scenario/franchir_etape')
                        . view('templates/bas');
                }
            }
        }
        return redirect()->to('/scenario/afficher');
    }

    public function scenario_reussite(){
        $session = session();
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'email' => 'required|max_length[200]|is_unique[t_participant_par.par_adresse]',
                        'name'=> 'required|max_length[80]',
                        'code'=>'required|exact_length[8]',
                        'niv'=>'required'
                    ],[
                        'name' => [
                            'required' => 'Veuillez entrer un nom !',
                            'max_length' => 'Le Nom est trop long'
                        ],
                        'email' => [
                            'required' => 'Veuillez entrer un nom !',
                            'max_length' => 'Le Mail est trop long',
                            'is_unique'=>'Email déja existant'
                        ],
                        'code' => [
                            'required' => 'Veuillez ne pas modifier les informations cachées',
                            'max_length' => 'Veuillez ne pas modifier les informations cachées'
                        ],
                        'niv' => [
                            'required' => 'Veuillez ne pas modifier les informations cachées'
                        ],
                    ]
                )
            ) { // La validation du formulaire a échoué, retour au formulaire !
                $saisie['code'] = $this->request->getVar('code');
                $saisie['niv']=$this->request->getVar('niv');
                $data['etape']=$this->model->get_etape($saisie);
                     if ($session->has('user')) {
                        if($session->get('role')=='A'){
                            return view('templates/haut',$data)
                            . view('templates/menu_administrateur')
                            . view('scenario/scenario_reussite')
                            . view('templates/bas');
                        }else{
                            return view('templates/haut',$data)
                            . view('templates/menu_organisateur')
                            . view('scenario/scenario_reussite')
                            . view('templates/bas');
                        }
                    } else {
                        return view('templates/haut',$data)
                            . view('templates/menu_visiteur')
                            . view('scenario/scenario_reussite')
                            . view('templates/bas');
                    }
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $saisie['email'] = $this->request->getVar('email');
            $saisie['name'] = $this->request->getVar('name');
            $saisie['code'] = $this->request->getVar('code');
            $saisie['niv'] = $this->request->getVar('niv');
            $this->model->set_participant($saisie);
            $this->model->set_reussite($saisie);
            $data['formfini']="Données Enregistrées";
        }
        if ($session->has('user')) {
            if($session->get('role')=='A'){
                return view('templates/haut',$data)
                . view('templates/menu_administrateur')
                . view('scenario/scenario_reussite')
                . view('templates/bas');
            }else{
                return view('templates/haut',$data)
                . view('templates/menu_organisateur')
                . view('scenario/scenario_reussite')
                . view('templates/bas');
            }
        } else {
            return view('templates/haut',$data)
                . view('templates/menu_visiteur')
                . view('scenario/scenario_reussite')
                . view('templates/bas');
        }
    }
}