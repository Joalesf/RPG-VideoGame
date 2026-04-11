<?php
require_once 'Origen.php';

class Personaje extends Origen
{
    public function __construct($nombre = 'Gandalf', $vida = 100, $mana = 100, $nivel = 1)
    {
        parent::__construct($nombre, $vida, $mana, $nivel);
        $this->desbloquearHabilidadesPorNivel();
    }

    public function desbloquearHabilidadesPorNivel()
    {
        $this->agregarHabilidad(new Habilidad('Golpe Basico', 0, 20));
        $this->agregarHabilidad(new Habilidad('Bola de Fuego', 30, 50));

        if ($this->nivel >= 5) {
            $this->agregarHabilidad(new Habilidad('Fragmento de Hielo', 25, 4));
        }

        if ($this->nivel >= 10) {
            $this->agregarHabilidad(new Habilidad('Impacto Electrico', 40, 60));
        }
    }
}

?>
