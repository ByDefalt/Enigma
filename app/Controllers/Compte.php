<?php
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Compte extends BaseController
{
    protected $model;
    public function __construct()
    {
        helper('form');
        $this->model = model(Db_model::class);
    }
    public function lister()
    {
        $data['titre'] = "Liste de tous les comptes";
        $data['logins'] = $this->model->get_all_compte();
        $data['nbcompte'] = $this->model->get_nb_compte();
        $session = session();
        if ($session->has('user')) {
            if ($session->get('role') == 'A') {
                return view('templates/haut', $data)
                    . view('templates/menu_administrateur')
                    . view('affichage_comptes')
                    . view('templates/bas');
            } else{
                return redirect()->to('/compte/afficher_profil');
            }
        } else {
            return redirect()->to('/compte/connecter');
        }
    }
    public function creer()
    {
        $session = session();
        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'pseudo' => 'required|max_length[255]|min_length[2]|is_unique[t_compte_com.com_pseudo]',
                        'mdp' => 'required|max_length[255]|min_length[8]',
                        'role' => 'in_list[A,O]',
                        'vali' => 'in_list[A,D]'
                    ],
                    [
                        // Configuration des messages d’erreurs
                        'pseudo' => [
                            'required' => 'Veuillez entrer un pseudo pour le compte !',
                            'is_unique' => 'Pseudo déja existant',
                        ],
                        'mdp' => [
                            'min_length' => 'Le mot de passe saisi est trop court !',
                            'required' => 'Veuillez entrer un mot de passe !',
                        ],
                        'role' => [
                            'in_list' => 'Le rôle doit être soit "A" ou "O".'
                        ],
                        'vali' => [
                            'in_list' => 'Le validité doit être soit "A" ou "D".'
                        ]
                    ]
                )
            ) {
                // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut')
                    . view( 'templates/menu_administrateur')
                    . view('compte/compte_creer')
                    . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $recuperation = $this->validator->getValidated();
            $this->model->set_compte($recuperation);
            $data['le_compte'] = $recuperation['pseudo'];
            $data['le_message'] = "Nouveau nombre de comptes : ";
            //Appel de la fonction créée dans le précédent tutoriel :
            $data['le_total'] = $this->model->get_nb_compte();
            return redirect()->to('/compte/lister');
        }
        if ($session->has('user')) {
            if($session->get('role')=='A'){
                return view('templates/haut')
                . view('templates/menu_administrateur')
                . view('compte/compte_creer')
                . view('templates/bas');
            }else{
                return redirect()->to('/compte/afficher_profil');
            }
        } else {
            return redirect()->to('/compte/connecter');
        }

    }
    public function connecter()
    {
        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate([
                    'pseudo' => 'required',
                    'mdp' => 'required'
                ],[
                    'pseudo'=>[
                        'required'=>'Veuillez entrer un pseudo'
                    ],
                    'mdp'=>[
                        'required'=>'Veuillez entrer un Mot de passe'
                    ]
                ])
            ) { // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut')
                    . view('templates/menu_visiteur')
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $username = $this->request->getVar('pseudo');
            $password = $this->request->getVar('mdp');
            if ($this->model->connect_compte($username, $password) == true) {
                session_set_cookie_params(3600);
                $session = session();
                $session->set('user', $username);
                if ($this->model->is_admin($username) == true) {
                    $session->set('role', 'A');
                } else {
                    $session->set('role', 'O');
                }
                if ($session->get('role') == 'A') {
                    return view('templates/haut')
                        . view('templates/menu_administrateur')
                        . view('connexion/compte_accueil')
                        . view('templates/bas');
                } else {
                    return view('templates/haut')
                        . view('templates/menu_organisateur')
                        . view('connexion/compte_accueil')
                        . view('templates/bas');
                }   
            }else{
                $data['erreur']="Identifiants erronés/inexistants ou compte désactivé !";
                return view('templates/haut',$data)
                        . view('templates/menu_visiteur')
                        . view('connexion/compte_connecter')
                        . view('templates/bas');
            }
        }
        // L’utilisateur veut afficher le formulaire pour se conncecter
        return view('templates/haut')
            . view('templates/menu_visiteur')
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }
    public function afficher_profil()
    {
        $session = session();
        if ($session->has('user')) {
            if ($session->get('role') == 'A') {
                return view('templates/haut')
                    . view('templates/menu_administrateur')
                    . view('connexion/compte_profil')
                    . view('templates/bas');
            } else {
                return view('templates/haut')
                    . view('templates/menu_organisateur')
                    . view('connexion/compte_profil')
                    . view('templates/bas');
            }
        } else {
            return redirect()->to('/compte/connecter');
        }
    }
    public function deconnecter()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('compte/connecter');
    }
    public function modifier_mdp()
    {
        $session = session();
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate(
                    [
                        'pseudo' => 'required|max_length[45]',
                        'mdp' => 'required|max_length[255]|min_length[8]',
                        'mdpchange' => 'required|max_length[255]|min_length[8]',
                        'mdpchangeconfirm'=> 'required|matches[mdpchange]'
                    ],
                    [
                        'pseudo' => [
                            'required' => 'Veuillez entrer un pseudo pour le compte !',
                            'max_length'=> 'Pseudo trop long !'
                        ],
                        'mdp' => [
                            'required' => 'Veuillez entrer un mot de passe !',
                            'min_length' => 'Le mot de passe saisi est trop court !',
                            'max_length'=>'Le mot de passe saisi est trop long !',
                        ],
                        'mdpchange' => [
                            'required' => 'Veuillez entrer un nouveaux mot de passe pour le compte !',
                            'min_length' => 'Le nouveau mot de passe saisi est trop court !',
                            'max_length'=>'Le nouveau mot de passe saisi est trop long !',
                        ],
                        'mdpchangeconfirm'=>[
                            'matches'=> 'Confirmation du mot de passe erronée, veuillez réessayer !',
                            'required' => 'Veuillez entrer une confirmation',
                        ]
                    ]
                )
            ) { // La validation du formulaire a échoué, retour au formulaire !
                if ($session->get('role') == 'A') {
                    return view('templates/haut')
                        . view('templates/menu_administrateur')
                        . view('connexion/compte_profil')
                        . view('templates/bas');
                } else {
                    return view('templates/haut')
                        . view('templates/menu_organisateur')
                        . view('connexion/compte_profil')
                        . view('templates/bas');
                }
            }
            // La validation du formulaire a réussi, traitement du formulaire
            $saisie['pseudo'] = $session->get('user');
            $saisie['mdpchange'] = $this->request->getVar('mdpchange');
            $saisie['mdp'] = $this->request->getVar('mdp');
            $this->model->update_compte($saisie);
        }
        if ($session->has('user')) {
            if ($session->get('role') == 'A') {
                return view('templates/haut')
                . view('templates/menu_administrateur')
                . view('connexion/compte_profil')
                . view('templates/bas');
            } else {
                return view('templates/haut')
                . view('templates/menu_organisateur')
                . view('connexion/compte_profil')
                . view('templates/bas');
            }
        }else{
            return redirect()->to('/compte/connecter');
        }
    }

}