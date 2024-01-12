<?php
namespace App\Models;

use CodeIgniter\Model;

class Db_model extends Model{

    protected $db;
    public function __construct(){
        $this->db = db_connect(); //charger la base de données
    }

    /*---------------------------------------------------------ACTUALITÉ-------------------------------------------------------*/
    /**
     * Récupère les dernières actualités actives.
     *
     * @return array Les actualités sous forme de tableau associatif.
     */
    public function get_all_actualite() {
        $requete = "SELECT * FROM actualité
        WHERE act_etat='A'
        ORDER BY act_date DESC
        LIMIT 5;";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }
    /**
     * Récupère une actualité spécifique par son numéro.
     *
     * @param int $numero Le numéro de l'actualité.
     *
     * @return object|false L'objet résultat contenant l'actualité, ou false si non trouvée.
     */
    public function get_actualite($numero) {
        $requete = "SELECT * FROM t_actualite_act WHERE id_actualite=" . htmlspecialchars(addslashes($numero)) . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }
    /*---------------------------------------------------------COMPTE----------------------------------------------------------*/
    /**
     * Récupère tous les comptes.
     *
     * @return array Les comptes sous forme de tableau associatif.
     */
    public function get_all_compte() {
        $resultat = $this->db->query("SELECT com_pseudo, com_role, com_active FROM t_compte_com ORDER BY com_active;");
        return $resultat->getResultArray();
    }
    /**
     * Récupère le nombre total de comptes.
     *
     * @return object L'objet résultat contenant le nombre total de comptes.
     */
    public function get_nb_compte() {
        $requete = "SELECT COUNT(*) AS nbcompte FROM t_compte_com;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }
    /**
     * Insère un nouveau compte dans la base de données.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return bool Renvoie true si l'insertion est réussie, sinon false.
     */
    public function set_compte($saisie) {
        // Récupération et traitement des données du formulaire
        $login = htmlspecialchars(addslashes($saisie['pseudo']));
        $mot_de_passe = htmlspecialchars(addslashes($saisie['mdp']));
        $role = htmlspecialchars(addslashes($saisie['role']));
        $validite=htmlspecialchars(addslashes($saisie['vali']));
        $sql = "INSERT INTO t_compte_com VALUES(NULL, '" . $login . "', '" . $mot_de_passe . "', '" . $role . "', '".$validite."');";
        return $this->db->query($sql);
    }
    
    /**
     * Vérifie si les informations de connexion d'un compte sont valides.
     *
     * @param string $u Nom d'utilisateur.
     * @param string $p Mot de passe.
     *
     * @return bool Renvoie true si les informations sont valides, sinon false.
     */
    public function connect_compte($u, $p) {
        $u = htmlspecialchars(addslashes($u));
        $p = htmlspecialchars(addslashes($p));
        $sql = "CALL connect_compte('".$u."','".$p."')";
        $resultat = $this->db->query($sql);
        return $resultat->getNumRows() > 0;
    }
    /**
     * Vérifie si un utilisateur est administrateur.
     *
     * @param string $u Nom d'utilisateur.
     *
     * @return bool Renvoie true si l'utilisateur est administrateur, sinon false.
     */
    public function is_admin($u) {
        $sql = "SELECT com_pseudo
                FROM t_compte_com
                WHERE com_pseudo='" . htmlspecialchars(addslashes($u)) . "'
                AND com_role='A';";
        $resultat = $this->db->query($sql);
        return $resultat->getNumRows() > 0;
    }
    
    /**
     * Met à jour le mot de passe d'un compte.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return bool Renvoie true si la mise à jour est réussie, sinon false.
     */
    public function update_compte($saisie) {
        $mot_de_passe = htmlspecialchars(addslashes($saisie['mdp']));
        $mot_de_passe_change = htmlspecialchars(addslashes($saisie['mdpchange']));
        $pseudo = htmlspecialchars(addslashes($saisie['pseudo']));
        $sql = "CALL update_compte('".$pseudo."','".$mot_de_passe."','".$mot_de_passe_change."')";
        return $this->db->query($sql);
    }
    /**
     * Vérifie si un compte existe dans la base de données.
     *
     * @param string $pseudo Nom d'utilisateur.
     *
     * @return bool Renvoie true si le compte existe, sinon false.
     */
    public function in_db_compte($pseudo) {
        $sql = "SELECT com_pseudo
                FROM t_compte_com
                WHERE com_pseudo='" . htmlspecialchars(addslashes($pseudo)) . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getNumRows() > 0;
    }
    /*---------------------------------------------------------SCENARIO--------------------------------------------------------*/
    
    /**
     * Récupère tous les scénarios actifs.
     *
     * @return array Les scénarios actifs sous forme de tableau associatif.
     */
    public function get_scenario_active() {
        $requete = "SELECT * FROM t_scenario_sce JOIN t_compte_com USING (com_id) WHERE sce_active='A';";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }

    /**
     * Récupère tous les scénarios avec le nombre d'étapes.
     *
     * @return array Les scénarios avec le nombre d'étapes sous forme de tableau associatif.
     */
    public function get_all_scenario() {
        $requete = "SELECT *, nbetape(sce_code) AS nb_etape FROM t_scenario_sce
                    JOIN t_compte_com USING (com_id)
                    LEFT JOIN t_etape_eta USING(sce_id)
                    GROUP BY sce_id;";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }

    /**
     * Récupère la première étape d'un scénario spécifique.
     *
     * @param string $scecode Le code du scénario.
     * @param string $indniveau Le niveau d'indice.
     *
     * @return object|false L'objet résultat contenant la première étape, ou false si non trouvée.
     */
    public function get_etape_1($scecode, $indniveau) {
        $requete = "SELECT *, " . htmlspecialchars(addslashes($indniveau)) . " AS niv FROM t_etape_eta
                    JOIN t_scenario_sce USING(sce_id)
                    JOIN t_compte_com USING(com_id)
                    JOIN t_ressource_res USING(res_id)
                    LEFT JOIN t_indice_ind ON (t_indice_ind.eta_id=t_etape_eta.eta_id AND t_indice_ind.ind_niveau='".htmlspecialchars(addslashes($indniveau))."')
                    WHERE sce_code='" . htmlspecialchars(addslashes($scecode)) . "'
                    AND eta_num=0";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }
    /**
     * Insère un nouveau scénario dans la base de données.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return bool Renvoie true si l'insertion est réussie, sinon false.
     */
    public function set_scenario($saisie) {
        $pseudo = htmlspecialchars(addslashes($saisie['pseudo']));
        $titre = htmlspecialchars(addslashes($saisie['titre']));
        $description = htmlspecialchars(addslashes($saisie['description']));
        $active = htmlspecialchars(addslashes($saisie['active']));
        $namefile = htmlspecialchars(addslashes($saisie['namefile']));
        $code = htmlspecialchars(addslashes($saisie['code']));
        $sql = "INSERT INTO t_scenario_sce
                VALUES(NULL,
                '" . $titre . "',
                '" . $description . "',
                '" . $active . "',
                '" . $code . "',
                '" . $namefile . "',(
                SELECT com_id FROM t_compte_com WHERE com_pseudo='" . $pseudo . "'));";
        return $this->db->query($sql);
    }

    /**
     * Supprime un scénario de la base de données.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return bool Renvoie true si la suppression est réussie, sinon false.
     */
    public function del_scenario($saisie) {
        $code = htmlspecialchars(addslashes($saisie['code']));
        $sql = "CALL scenario_supprimer('" . $code . "');";
        return $this->db->query($sql);
    }

    /**
     * Récupère les détails d'un scénario spécifique.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return array Les détails du scénario sous forme de tableau associatif.
     */
    public function get_scenario_details($saisie) {
        $code = htmlspecialchars(addslashes($saisie['code']));
        $sql = "SELECT * FROM t_scenario_sce
                LEFT JOIN t_etape_eta USING(sce_id)
                JOIN t_compte_com USING(com_id)
                WHERE sce_code='" . $code . "'";
        $resultat = $this->db->query($sql);
        return $resultat->getResultArray();
    }
    /**
     * Récupère un scénario avec son code.
     *
     * @param string $code Le code du scenario.
     *
     * @return object|false L'objet résultat contenant le scénario, ou false si non trouvé.
     */
    public function get_scenario($code) {
        $code = htmlspecialchars(addslashes($code));
        $sql = "SELECT * FROM t_scenario_sce
                WHERE sce_code='" . $code . "'";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    /**
     * Récupère un scénario avec une étape spécifique.
     *
     * @param string $code_etape Le code de l'étape.
     *
     * @return object|false L'objet résultat contenant le scénario, ou false si non trouvé.
     */
    public function get_scenario_with_etape($code_etape) {
        $code_etape = htmlspecialchars(addslashes($code_etape));
        $sql = "SELECT * FROM t_scenario_sce
                JOIN t_etape_eta USING(sce_id)
                JOIN t_compte_com USING(com_id)
                WHERE eta_code='" . $code_etape . "'
                GROUP BY sce_id";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    /**
     * Vérifie si une réponse à une étape est valide.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return bool Renvoie true si la réponse est valide, sinon false.
     */
    public function reponsse_is_valid($saisie) {
        $code = htmlspecialchars(addslashes($saisie['code']));
        $reponsse = htmlspecialchars(addslashes($saisie['reponsse']));
        $sql = "SELECT * FROM t_etape_eta
                WHERE eta_code='" . $code . "'
                AND eta_reponsse='" . $reponsse . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getNumRows() > 0;
    }

    /**
     * Récupère l'étape suivante d'un scénario.
     *
     * @param array $saisie Les données du formulaire.
     *
     * @return object|false L'objet résultat contenant l'étape suivante, ou false si non trouvée.
     */
    public function get_next_etape($saisie) {
        $code = htmlspecialchars(addslashes($saisie['code']));
        $niveau = htmlspecialchars(addslashes($saisie['niv']));
        $sql = "SELECT *, " . $niveau . " AS niv FROM t_etape_eta
                JOIN t_ressource_res USING(res_id)
                JOIN t_scenario_sce USING(sce_id)
                LEFT JOIN t_indice_ind ON (ind_niveau='" . htmlspecialchars(addslashes($saisie['niv'])) . "' AND t_indice_ind.eta_id=t_etape_eta.eta_id)
                WHERE sce_id=(SELECT sce_id FROM t_etape_eta 
                                WHERE eta_code='" . $code . "')
                AND eta_num=(SELECT eta_num FROM t_etape_eta 
                                WHERE eta_code='" . $code . "')+1";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }


    /**
     * Récupère les détails d'une étape.
     *
     * @param array $saisie Les données de l'étape.
     *
     * @return object L'objet résultat contenant les détails de l'étape.
     */
    public function get_etape($saisie) {
        $niveau = htmlspecialchars(addslashes($saisie['niv']));
        $code_etape = htmlspecialchars(addslashes($saisie['code']));
        $sql = "SELECT *," . $niveau . " AS niv FROM t_etape_eta
        JOIN t_ressource_res USING(res_id)
        JOIN t_scenario_sce USING(sce_id)
        LEFT JOIN t_indice_ind ON (ind_niveau='" . htmlspecialchars(addslashes($saisie['niv'])) . "' AND t_indice_ind.eta_id=t_etape_eta.eta_id)
        WHERE sce_id=(SELECT sce_id FROM t_etape_eta WHERE eta_code='" . $code_etape . "')
        AND eta_code='" . $code_etape . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    /**
     * Vérifie si c'est la première étape.
     *
     * @param string $code_etape Le code de l'étape.
     *
     * @return bool Renvoie true si c'est la première étape, sinon false.
     */
    public function is_first_etape($code_etape) {
        $code_etape = htmlspecialchars(addslashes($code_etape));
        $sql = "SELECT * FROM t_etape_eta WHERE eta_code='" . $code_etape . "' AND eta_num=0;";
        $resultat = $this->db->query($sql);
        return ($resultat->getNumRows() > 0);
    }
    /*---------------------------------------------------------REUSSITE/PARTICIPANT----------------------------------------------*/
    
    /**
     * Ajoute un participant.
     *
     * @param array $saisie Les données du participant.
     *
     * @return bool Renvoie true si l'insertion a réussi, sinon false.
     */
    public function set_participant($saisie) {
        $name = htmlspecialchars(addslashes($saisie['name']));
        $email = htmlspecialchars(addslashes($saisie['email']));
        $sql = "INSERT INTO t_participant_par VALUES(null, '" . $email . "', '" . $name . "');";
        return $this->db->query($sql);
    }

    /**
     * Ajoute une réussite pour un participant.
     *
     * @param array $saisie Les données de la réussite.
     *
     * @return bool Renvoie true si l'insertion a réussi, sinon false.
     */
    public function set_reussite($saisie) {
        $code = htmlspecialchars(addslashes($saisie['code']));
        $niv = htmlspecialchars(addslashes($saisie['niv']));
        $email = htmlspecialchars(addslashes($saisie['email']));
        $sql = "INSERT INTO t_reussite_reu VALUES(
            (SELECT par_id FROM t_participant_par WHERE par_adresse='" . $email . "'),
            (SELECT sce_id FROM t_etape_eta WHERE eta_code='" . $code . "'),
            NOW(),
            NOW(),
            '" . $niv . "'
        );";
        return $this->db->query($sql);
    }
}
