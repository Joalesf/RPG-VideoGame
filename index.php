<?php
// Integrantes:
// Richard Rdriguez
// Edgar Rosario
// Jose Sanchez
// Leonardo Liang

require_once 'Personaje.php';
require_once 'Enemigo.php';
require_once 'Ronda_Ataque.php';

srand(2);

function mostrarHabilidades($personaje)
{
    $nombres = array();

    foreach ($personaje->getHabilidades() as $habilidad) {
        $nombres[] = $habilidad->getNombre();
    }

    echo 'Habilidades de ' . $personaje->getNombre() . ': ' . implode(', ', $nombres) . PHP_EOL;
}

function ejecutarCombate($titulo, $personaje, $enemigo, $maximoTurnos)
{
    $ronda = new Ronda_Ataque();

    echo PHP_EOL;
    echo $titulo . PHP_EOL;
    echo str_repeat('-', strlen($titulo)) . PHP_EOL;
    echo $enemigo->getNombre() . ' aparece con ' . $enemigo->getVida() . ' de vida.' . PHP_EOL;

    $turno = 1;

    while ($enemigo->estaVivo() && $turno <= $maximoTurnos) {
        echo 'Turno ' . $turno . PHP_EOL;

        try {
            $ronda->ejecutarAtaqueAleatorio($personaje, $enemigo);
        } catch (Exception $error) {
            echo 'Excepcion controlada: ' . $error->getMessage() . PHP_EOL;
            break;
        }

        $turno++;
    }

    if ($enemigo->estaVivo()) {
        echo $enemigo->getNombre() . ' sobrevivio a esta demostracion.' . PHP_EOL;
    }
}

echo 'SIMULACION DE COMBATE RPG' . PHP_EOL;
echo '=========================' . PHP_EOL;

$gandalf = new Personaje('Gandalf', 120, 100, 1);
mostrarHabilidades($gandalf);

$orco = new Enemigo('Orco', 140, 0, 1);
ejecutarCombate('COMBATE 1 - NIVEL 1', $gandalf, $orco, 4);

echo PHP_EOL . 'Gandalf gano experiencia en el combate.' . PHP_EOL;
$gandalf->recuperarManaCompleto();
$gandalf->subirNivel(5);
mostrarHabilidades($gandalf);

$trol = new Enemigo('Trol de Hielo', 120, 0, 5);
ejecutarCombate('COMBATE 2 - NIVEL 5', $gandalf, $trol, 5);

echo PHP_EOL . 'Gandalf gano experiencia otra vez.' . PHP_EOL;
$gandalf->recuperarManaCompleto();
$gandalf->subirNivel(10);
mostrarHabilidades($gandalf);

$dragon = new Enemigo('Dragon Joven', 180, 0, 10);
ejecutarCombate('COMBATE 3 - NIVEL 10', $gandalf, $dragon, 6);

echo PHP_EOL;
echo 'PRUEBAS DE EXCEPCIONES' . PHP_EOL;
echo '----------------------' . PHP_EOL;

$aprendiz = new Personaje('Aprendiz', 100, 10, 1);
$muneco = new Enemigo('Muneco de Prueba', 60, 0, 1);

try {
    $aprendiz->usarHabilidad('Bola de Fuego', $muneco);
} catch (Exception $error) {
    echo 'Excepcion controlada: ' . $error->getMessage() . PHP_EOL;
}

try {
    $aprendiz->usarHabilidad('Impacto Electrico', $muneco);
} catch (Exception $error) {
    echo 'Excepcion controlada: ' . $error->getMessage() . PHP_EOL;
}

?>
