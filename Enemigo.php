<?php
require_once 'Origen.php';

class Enemigo extends Origen
{
    public function __construct($nombre = 'Orco', $vida = 100, $mana = 0, $nivel = 1)
    {
        parent::__construct($nombre, $vida, $mana, $nivel);
        $this->desbloquearHabilidadesPorNivel();
    }

    public function desbloquearHabilidadesPorNivel()
    {
    }
}

?>
