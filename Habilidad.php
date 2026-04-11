<?php
require_once 'Origen.php';
class Habilidad extends Origen{
    private $habilidades = [
        ["numero" => 1, "name" => "Golpe Basico", "dañoBase" => 20, "constoMana" => 0],
        ["numero" => 2, "name" => "Bola de Fuego", "dañoBase" => 50, "constoMana" => 30],
    ];

    public function newhabilidad($nivel) {
            switch ($nivel) {
                case 5:
                    $this->habilidades[] = ["numero" => 3, "name" => "Framento de Hielo", "dañoBase" => 40, "constoMana" => 25];
                    echo $this->nombre . " aprendió: Fragmento de Hielo, costo de mana: 25, daño base: 40 <br>";
                    break;
                case 10:
                    $this->habilidades[] = ["numero" => 4, "name" => "Rayo de Trueno", "dañoBase" => 60, "constoMana" => 40];
                    echo $this->nombre . " aprendió: Rayo de Trueno, costo de mana: 40, daño base: 60 <br>";
                    break;
                default:
                    echo "No hay nuevas habilidades disponibles para este nivel. <br>";
                    break;
            }
        }

}

?>