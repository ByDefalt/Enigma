<?php
namespace App\Models;

use CodeIgniter\Model;

class Db_model extends Model
{
    protected $db;
    public function __construct()
    {
        $this->db = db_connect(); //charger la base de données
// ou
// $this->db = \Config\Database::connect();

    }
    public function get_all_compte()
    {
        $resultat = $this->db->query("SELECT com_pseudo,com_role,com_active FROM t_compte_com
        ORDER BY com_active;");
        return $resultat->getResultArray();
    }
    public function get_nb_compte()
    {
        $requete = "SELECT COUNT(*) AS nbcompte FROM t_compte_com ;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }
    public function set_compte($saisie)
    {
        //Récuparation (+ traitement si nécessaire) des données du formulaire
        $login = htmlspecialchars(addslashes($saisie['pseudo']));
        $mot_de_passe = htmlspecialchars(addslashes($saisie['mdp']));
        $role = htmlspecialchars(addslashes($saisie['role']));
        $sql = "INSERT INTO t_compte_com VALUES(NULL,'" . $login . "','" . $mot_de_passe . "','" . $role . "','D');";
        return $this->db->query($sql);
    }
    public function get_all_actualite()
    {
        $requete = "SELECT act_intitule,act_desc,act_etat,act_date,com_pseudo FROM t_actualite_act
        JOIN t_compte_com USING (com_id)
        WHERE act_etat='A';";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }
    public function get_actualite($numero)
    {
        $requete = "SELECT * 
        FROM t_actualite_act 
        WHERE idactualite=" . htmlspecialchars(addslashes($numero)) . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }
    public function get_scenario_active()
    {
        $requete = "
        SELECT * FROM t_scenario_sce
        JOIN t_compte_com USING (com_id)
        WHERE sce_active='A';";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }
    public function get_all_scenario()
    {
        $requete = "
        SELECT * FROM t_scenario_sce
        JOIN t_compte_com USING (com_id);";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }
    public function get_etape_1($scecode, $indniveau)
    {
        $requete = "
        SELECT * FROM t_etape_eta
        JOIN t_scenario_sce USING(sce_id)
        JOIN t_ressource_res USING (res_id)
        LEFT JOIN t_indice_ind ON (ind_niveau='" . htmlspecialchars(addslashes($indniveau)) . "' AND t_indice_ind.eta_id=t_etape_eta.eta_id)
        WHERE sce_code='" . htmlspecialchars(addslashes($scecode)) . "'
        AND eta_num=0;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }
    public function connect_compte($u, $p)
    {
        $sql = "SELECT com_pseudo,com_mdp
                FROM t_compte_com
                WHERE com_pseudo='" . htmlspecialchars(addslashes($u)) . "'
                AND com_mdp=SHA2('" . htmlspecialchars(addslashes($p)) . "cdzjhvebturgtfv8745eg4e8tghe8r5f7e',256)
                AND com_active='A';";
        $resultat = $this->db->query($sql);
        if ($resultat->getNumRows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function is_admin($u)
    {
        $sql = "SELECT com_pseudo
        FROM t_compte_com
        WHERE com_pseudo='" . htmlspecialchars(addslashes($u)) . "'
        AND com_role='A';";
        $resultat = $this->db->query($sql);
        if ($resultat->getNumRows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function in_db_compte($pseudo)
    {
        $sql = "SELECT com_pseudo
        FROM t_compte_com
        WHERE com_pseudo='" . htmlspecialchars(addslashes($pseudo)) . "';";
        $resultat = $this->db->query($sql);
        if ($resultat->getNumRows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function update_compte($saisie)
    {
        $mot_de_passe = htmlspecialchars(addslashes($saisie['mdp']));
        $mot_de_passe_change = htmlspecialchars(addslashes($saisie['mdpchange']));
        $pseudo=htmlspecialchars(addslashes($saisie['pseudo']));
        $sql = "UPDATE t_compte_com
        SET com_mdp='" . $mot_de_passe_change . "'
        WHERE com_mdp=SHA2(CONCAT('" . $mot_de_passe . "','cdzjhvebturgtfv8745eg4e8tghe8r5f7e'),256)
        AND com_pseudo='".$pseudo."'";
        return $this->db->query($sql);
    }
    //pas oublier comentaire
}