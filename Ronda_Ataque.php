<?php
require_once 'Origen.php';

class Ronda_Ataque
{
    private $contadorAtaquesNormales;

    public function __construct()
    {
        $this->contadorAtaquesNormales = 0;
    }

    public function ejecutarAtaqueAleatorio(Origen $atacante, CombatienteInterface $objetivo)
    {
        $habilidadesUsables = $atacante->obtenerHabilidadesUsables();

        if (count($habilidadesUsables) === 0) {
            throw new Exception($atacante->getNombre() . ' no tiene habilidades disponibles por falta de mana.');
        }

        $indice = rand(0, count($habilidadesUsables) - 1);
        $habilidadElegida = $habilidadesUsables[$indice];
        $esCritico = false;

        if ($this->contadorAtaquesNormales === 3) {
            $esCritico = true;
            $this->contadorAtaquesNormales = 0;
        } else {
            $this->contadorAtaquesNormales++;
        }

        $atacante->usarHabilidad($habilidadElegida->getNombre(), $objetivo, $esCritico);
    }
}

?>
