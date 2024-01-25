<?php
    if (!MY_APP){
        die("Fichier externe détecté");
    }
    include_once 'C:\wamp64\www\Site-Javaski\Javaski\vue_generique.php';
    include_once 'C:\wamp64\www\Site-Javaski\Javaski\connexion.php';

    class ModeleProfil extends Connexion{
        public function __construct(){
            parent::initConnexion();
            // vide actuellement
        }

        public function get_profil($id){
            $query= "SELECT * FROM utilisateur WHERE idUtilisateur=:id";
            $prepare = $bdd->prepare($query);
            $prepare->execute(['id'=>$id]);
            $rep= $prepare->fetchAll();

            return $rep;
        }

        public function get_demandes(){
            $query= "SELECT
            utilisateur.identififant
        FROM
            demande_ami
        JOIN
            utilisateur ON demande_ami.idUtilisateur1 = utilisateur.idUtilisateur
        WHERE
            demande_ami.idUtilisateur2 = :id ;";

            $prepare = $bdd->prepare($query);
            $prepare->execute(['id'=>$_SESSION["id"]]);
            $rep= $prepare->fetchAll();

            return $rep;
        }

        public function accepterDemandeAmi($idAmi) {
            $req = "
            INSERT INTO est_ami_avec (idUtilisateur1, idUtilisateur2) values (:idAmi, :id);
            DELETE FROM demande_ami WHERE idUtilisateur1=:idAmi AND idUtilisateur2=:id";
            $pdo_req = self::$bdd->query($req);
            $pdo_req->execute([ 'id', 'idAmi'=>htmlspecialchars($_SESSION['id']), $idAmi ]);

        }

        public function refuserDemandeAmi($idAmi) {
            $req = "
            DELETE FROM demande_ami WHERE idUtilisateur1=:idAmi AND idUtilisateur2=:id";
            $pdo_req = self::$bdd->query($req);
            $pdo_req->execute([ 'id', 'idAmi'=>htmlspecialchars($_SESSION['id']), $idAmi ]);
        }
        
        public function get_historiqueParties () {
            $req = "SELECT partie.score, partie.victoire FROM utilisateur inner join a_joué using(idUtilisateur) inner join partie where utilisateur.idUtilisateur=:id";
            $pdo_req = self::$bdd->query($req);
            $pdo_req->execute(['id'=>htmlspecialchars($_SESSION["id"])]);
            return $pdo_req->fetchAll();
        }
        
        public function get_listeAmis () {
            $req = "SELECT utilisateur.pseudo, utilisateur.courriel, utilisateur.droits FROM est_ami_avec inner join utilisateur on(idUtilisateur2=idUtilisateur) where est_ami_avec.idUtilisateur1=:id";
            $pdo_req = self::$bdd->query($req);
            $pdo_req->execute(['id'=>htmlspecialchars($_SESSION["id"])]);
            return $pdo_req->fetchAll();
        }
        

    }
?>