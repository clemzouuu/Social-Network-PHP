<?php


class Profil {
    public $pseudo;
    public $ville;
    public $ecole;
    public $specialite;
    public $age;
    public $image;
    public $second_image;

    public function __construct($pseudo,$ville,$ecole,$specialite,$age,$image,$second_image)

    {
        $this->pseudo = $pseudo;
        $this->ville = $ville;
        $this->ecole = $ecole;
        $this->specialite = $specialite;
        $this->age = $age;
        $this->image = $image;
        $this->second_image = $second_image;
    }

    public function afficher_infos()
    {
        echo $this->pseudo,$this->ville,$this->ecole,$this->specialite,$this->age,$this->image,$this->second_image;
    }
 

}
 
$eleve = new Profil($_SESSION["login"],2,1,2,3,4,5); 
$eleve->afficher_infos();

?>