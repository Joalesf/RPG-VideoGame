<?php
require_once 'CombatienteInterface.php';
require_once 'Habilidad.php';

abstract class Origen implements CombatienteInterface
{
    protected $nombre;
    protected $vida;
    protected $mana;
    protected $manaMaximo;
    protected $nivel;
    protected $habilidades;

    public function __construct($nombre, $vida = 100, $mana = 100, $nivel = 1)
    {
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->mana = $mana;
        $this->manaMaximo = $mana;
        $this->nivel = $nivel;
        $this->habilidades = array();
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getVida()
    {
        return $this->vida;
    }

    public function getMana()
    {
        return $this->mana;
    }

    public function getNivel()
    {
        return $this->nivel;
    }

    public function getHabilidades()
    {
        return array_values($this->habilidades);
    }

    public function agregarHabilidad(Habilidad $habilidad)
    {
        $nombreHabilidad = $habilidad->getNombre();

        if (!isset($this->habilidades[$nombreHabilidad])) {
            $this->habilidades[$nombreHabilidad] = $habilidad;
            echo $this->nombre . ' aprendio: ' . $nombreHabilidad . PHP_EOL;
        }
    }

    public function tieneHabilidad($nombreHabilidad)
    {
        return isset($this->habilidades[$nombreHabilidad]);
    }

    public function obtenerHabilidad($nombreHabilidad)
    {
        if (!$this->tieneHabilidad($nombreHabilidad)) {
            throw new Exception($this->nombre . ' no conoce la habilidad ' . $nombreHabilidad . '.');
        }

        return $this->habilidades[$nombreHabilidad];
    }

    public function obtenerHabilidadesUsables()
    {
        $habilidadesUsables = array();

        foreach ($this->habilidades as $habilidad) {
            if ($habilidad->getCostoMana() <= $this->mana) {
                $habilidadesUsables[] = $habilidad;
            }
        }

        return $habilidadesUsables;
    }

    public function gastarMana($cantidadMana)
    {
        if ($cantidadMana > $this->mana) {
            throw new Exception($this->nombre . ' no tiene suficiente mana para usar esa habilidad.');
        }

        $this->mana = $this->mana - $cantidadMana;
    }

    public function recuperarManaCompleto()
    {
        $this->mana = $this->manaMaximo;
        echo $this->nombre . ' recupero todo su mana. Mana actual: ' . $this->mana . PHP_EOL;
    }

    public function usarHabilidad($nombreHabilidad, CombatienteInterface $objetivo, $esCritico = false)
    {
        if (!$this->estaVivo()) {
            throw new Exception($this->nombre . ' no puede atacar porque ya fue derrotado.');
        }

        if (!$objetivo->estaVivo()) {
            throw new Exception($objetivo->getNombre() . ' ya fue derrotado.');
        }

        $habilidad = $this->obtenerHabilidad($nombreHabilidad);
        $this->gastarMana($habilidad->getCostoMana());

        $danio = $habilidad->getDanioBase();

        if ($esCritico) {
            $danio = $danio * 2;
            echo 'Golpe critico de ' . $this->nombre . ' con ' . $habilidad->getNombre() . '.' . PHP_EOL;
        } else {
            echo $this->nombre . ' uso ' . $habilidad->getNombre() . '.' . PHP_EOL;
        }

        echo 'Mana restante de ' . $this->nombre . ': ' . $this->mana . PHP_EOL;
        $objetivo->recibirDanio($danio);
    }

    public function recibirDanio($danio)
    {
        $this->vida = $this->vida - $danio;

        if ($this->vida < 0) {
            $this->vida = 0;
        }

        echo $this->nombre . ' recibio ' . $danio . ' de dano. Vida restante: ' . $this->vida . PHP_EOL;

        if (!$this->estaVivo()) {
            echo $this->nombre . ' ha sido derrotado!' . PHP_EOL;
        }
    }

    public function estaVivo()
    {
        return $this->vida > 0;
    }

    public function subirNivel($nuevoNivel)
    {
        if ($nuevoNivel <= $this->nivel) {
            return;
        }

        $this->nivel = $nuevoNivel;
        echo $this->nombre . ' subio al nivel ' . $this->nivel . '.' . PHP_EOL;
        $this->desbloquearHabilidadesPorNivel();
    }

    abstract public function desbloquearHabilidadesPorNivel();
}

?>
