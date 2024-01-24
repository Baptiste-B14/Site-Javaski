<?php
    if (!MY_APP){
        die("Fichier externe détécté");
    }
    
    include_once 'vue_score.php';
    include_once 'modele_score.php';

    class ContScore{
        private $vue;
        private $modele;
        private $action;

        public function __construct (){
            $this->vue = new VueScore();
            $this->modele = new ModeleScore();
        }

        public function exec (){
            // si $a est vide alors 'meilleursU', sinon il prend la valeur de $a
            $this->action = isset($_GET['action']) ? $_GET['action'] : 'meilleursU';

            switch ($this->action){
                case "meilleursU" :
                    $this->meilleursU();
                    break;  
                case "" :                    
                    break; 
                default :
                    die ("action inexistante");           
            }
        }

        public function getAction() {
            return $this->action;
        }

        public function meilleursU(){
            $map = $this->vue->menu();
            
            // récup dans BD les meilleurs utilisateurs 
            $listeMU = $this->modele->get_meilleursUtilisateurs($map);
            // affiche la liste
            $this->vue->afficherMU($listeMU);
        }

        



    }
    
?>