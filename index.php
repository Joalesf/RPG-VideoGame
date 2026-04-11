<?php
//Integrantes
//Richard Rdriguez
//Edgar Rosario
//Jose Sanchez
//Leonardo Liang

/* Desarrolle el siguiente problema (100 puntos) 
Desarrollar un sistema de combate para un videojuego RPG usando 
programación orientada a objetos (POO) en PHP. Deberán aplicar 
composición, interfaces, herencia y manejo de excepciones.  

Personaje: 
Debe tener: nombre, vida, mana (energía, ki, chakra, etc.), habilidades. 
Añadir una habilidad al personaje. 
Ejecutar la habilidad (valida mana y existencia de la habilidad). 
Reducir la vida y muestre mensaje. 
Validar si el personaje tiene vida. 
Habilidad: 
Debe tener: nombre, coste, daño base. 

Daños 
Daño fijo.  
Daño aleatorio (daño crítico o “Crítical hit”). 

Ejemplo de Salida Esperada: 
Gandalf aprendió: Bola de Fuego  
Orco recibió 50 de daño. Vida restante: 70 
Orco recibió 85 de daño. Vida restante: 0 
¡Orco ha sido derrotado! 

Retos avanzados (Opcionales, Puntos Adicionales) 
Efectos de Estado: Ejemplo: Quemadura, que aplica daño por turno.  
Inventario con Items: tipo del ítem (si es una poción o arma), nombre, peso. 
Otros eventos: Gandalf aprendió una habilidad adicional, Gandalf ganó 25 de experiencia, Gandalf subió a nivel 3.   
 */

//solamente se agregara habilidades cada 5 niveles del personaje, y el daño critico se dara cada 3 ataques normales, el daño critico sera el doble del daño base de la habilidad.
abstract class Origen {
    public $vida = 100; 
    public $nombre; 
    public $mana = 100;
    public $habilidades = [];
    public $nivel = 1;

    public function __construct($nombre, $vida, $mana, $habilidades = [], $nivel = 1) {
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->mana = $mana;
        $this->nivel = $nivel;
    }

    if (nivel % 5 == 0) {
        //se llamara a un metodo para agregar una nueva habilidad al personaje
        abstract public function newhabilidad($nivel);
        }
    }



?>
