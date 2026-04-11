<?php
interface CombatienteInterface
{
    public function getNombre();
    public function getVida();
    public function recibirDanio($danio);
    public function estaVivo();
}

?>
