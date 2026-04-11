<?php
require_once 'HabilidadInterface.php';

class Habilidad implements HabilidadInterface
{
    private $nombre;
    private $costoMana;
    private $danioBase;

    public function __construct($nombre, $costoMana, $danioBase)
    {
        $this->nombre = $nombre;
        $this->costoMana = $costoMana;
        $this->danioBase = $danioBase;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCostoMana()
    {
        return $this->costoMana;
    }

    public function getDanioBase()
    {
        return $this->danioBase;
    }
}

?>
