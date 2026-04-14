<?php
class Ronda_Ataque {
    private function pausaCorta($microsegundos = 500000) {
        if (function_exists('ob_flush')) {
            @ob_flush();
        }
        flush();
        usleep($microsegundos);
    }

    public function iniciarCombate($personaje, $enemigo) {

        $ronda = 1;
        while ($personaje->getVida() > 0 && $enemigo->getVida() > 0) {
            echo "<strong>Ronda $ronda:</strong><br>";
            $this->pausaCorta();
            
            // Personaje ataca
            $this->atacar($personaje, $enemigo);
            $this->pausaCorta();
            $personaje->experiencia += 25;
            while ($personaje->experiencia >= 15) {
                $personaje->subirNivel();
                $this->pausaCorta(350000);
                $personaje->experiencia -= 15;
            }
            
            if ($enemigo->getVida() > 0) {
                // Enemigo ataca con habilidad aleatoria
                $habilidadesEnemigo = $enemigo->getHabilidades();
                $habilidadEnemigo = $habilidadesEnemigo[array_rand($habilidadesEnemigo)];
                $dañoEnemigo = $habilidadEnemigo['dañoBase'];
                echo $enemigo->getNombre() . " usó " . $habilidadEnemigo['name'] . " causando " . $dañoEnemigo . " de daño.<br>";
                $this->pausaCorta();
                try {
                    $personaje->recibirDaño($dañoEnemigo);
                    $this->pausaCorta();
                } catch (Exception $e) {
                    echo $e->getMessage() . "<br>";
                    $this->pausaCorta();
                }
            }
            
            $ronda++;
            echo "<br>";
            $this->pausaCorta(700000);
        }

        if ($personaje->getVida() > 0) {
            echo "<strong>¡Victoria!</strong> " . $personaje->getNombre() . " derrotó al enemigo.<br>";
        } else {
            echo "<strong>Derrota:</strong> " . $personaje->getNombre() . " fue derrotado.<br>";
        }
        $this->pausaCorta();
    }

    public function atacar($personaje, $enemigo) {
        $habilidades = $personaje->getHabilidades();
        $habilidad = $habilidades[array_rand($habilidades)];
        
        // Si no tiene mana suficiente, usar Golpe Básico
        if ($personaje->getMana() < $habilidad['constoMana']) {
            $habilidad = $habilidades[0]; // Golpe Básico
            echo $personaje->getNombre() . " no tiene suficiente mana, usando Golpe Básico.<br>";
            $this->pausaCorta(300000);
        }

        $daño = $habilidad['dañoBase'];
        if (rand(1, 2) == 1) {
            $daño *= 4;
            echo "¡Golpe crítico! ";
            $this->pausaCorta(300000);
        }

        $personaje->reduceMana($habilidad['constoMana']);

        // Atacar al enemigo y reducir su vida
        echo $personaje->getNombre() . " usó " . $habilidad['name'] . " y causó " . $daño . " de daño. " . "<br>" ;
        $this->pausaCorta();
        $enemigo->recibirDaño($daño);
    }
}

?> 
