<?php
require_once 'Ronda_Ataque.php';
require_once 'Habilidad.php';
class Personaje {
    private $nombre;
    private $vida;
    private $mana;
    private $nivel;
    private $habilidad;

    public function __construct($nombre = "Gandalf", $vida = 100, $mana = 100, $nivel = 1) {
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->mana = $mana;
        $this->nivel = $nivel;
        $this->habilidad = new Habilidad();
    }
    
    if (nivel % 5 == 0) {
        //se llamara a un metodo para agregar una nueva habilidad al personaje
        abstract public function newhabilidad($nivel);
        }
}

?>
