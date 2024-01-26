<?php

include_once 'mod_admin/vue_admin.php';
include_once 'mod_admin/modele_admin.php';


class ContAdmin{
	private $vue;
	private $modele;

	public function __construct() {
		$this->modele=new ModeleAdmin();
		$this->vue= new VueAdmin();
	}

	public function getAffichageAdmin(){
		$this->action = isset($_GET['action']) ? $_GET['action'] : 'affichage outils';

            switch ($this->action){  
                case "accepterUser" :
                    $this->accepterUser();
                    break;
                case "refuserUser" :
                    $this->refuserUser();
                    break;
                case "affichage outils":
                    break;
                default :
                    die ("action inexistante");           
            }
	}
	public function getModele(){
		return $this->modele;
	}


	public function accepterUser(){
		$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : 0 ;   
		$this->modele->accepterUser($idUser);               
	}

	public function refuserUser(){
		$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : 0 ;
		$this->modele->refuserUser($idUser);
	}
	
	public function getAffichage(){
		$demandesCreationComptes = $this->modele->get_listeDemandeurs();
		return $this->vue->afficheProfil($demandesCreationComptes);
	
	}
}




?>