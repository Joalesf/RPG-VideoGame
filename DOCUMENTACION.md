# Documentacion del proyecto

## 1. Que hace este proyecto

Este proyecto simula un combate de texto para un videojuego RPG usando PHP basico.  
No recibe datos del usuario. Todo esta predefinido en `index.php`.

El personaje principal es `Gandalf` y pelea contra varios enemigos para demostrar:

- herencia
- clase abstracta
- interfaces
- composicion
- manejo de excepciones con `try/catch`
- habilidades con dano fijo
- golpe critico
- habilidades desbloqueadas por nivel
- seleccion aleatoria de habilidades disponibles

## 2. Estructura de archivos

### `Origen.php`

Aqui esta la clase abstracta del proyecto.

Se llama abstracta porque no se usa directamente para crear objetos.  
Sirve como base para otras clases.

Esta clase guarda lo comun que tienen `Personaje` y `Enemigo`:

- nombre
- vida
- mana
- nivel
- habilidades

Tambien incluye metodos comunes como:

- `agregarHabilidad()`
- `usarHabilidad()`
- `recibirDanio()`
- `estaVivo()`
- `subirNivel()`
- `recuperarManaCompleto()`

Al final tiene un metodo abstracto:

- `desbloquearHabilidadesPorNivel()`

Ese metodo obliga a las clases hijas a tener su propia version.

### `Personaje.php`

Esta clase hereda de `Origen`.

Su trabajo es crear el personaje principal y desbloquear habilidades segun el nivel:

- `Golpe Basico`: dano 20, mana 0
- `Bola de Fuego`: dano 50, mana 30
- `Fragmento de Hielo`: dano 4, mana 25, se desbloquea al nivel 5
- `Impacto Electrico`: dano 60, mana 40, se desbloquea al nivel 10

### `Enemigo.php`

Tambien hereda de `Origen`.

En este proyecto se usa principalmente para recibir dano y mostrar que hay varias clases hijas de la clase abstracta.

### `Habilidad.php`

Representa una habilidad individual.

Cada habilidad tiene:

- nombre
- costo de mana
- dano base

Aqui no hay herencia porque una habilidad no es un personaje.  
Se usa composicion, porque el personaje tiene un arreglo de objetos `Habilidad`.

### `CombatienteInterface.php`

Esta interfaz define lo minimo que debe poder hacer alguien dentro del combate:

- devolver nombre
- devolver vida
- recibir dano
- validar si sigue vivo

### `HabilidadInterface.php`

Esta interfaz define lo minimo que debe tener una habilidad:

- nombre
- costo de mana
- dano base

### `Ronda_Ataque.php`

Esta clase controla una ronda de ataque.

Hace tres cosas importantes:

1. Busca las habilidades que el personaje puede usar con el mana actual.
2. Elige una habilidad al azar con `rand()`.
3. Activa un golpe critico despues de 3 ataques normales.

Cuando el golpe es critico, el dano final es el doble del dano base.

### `index.php`

Es el archivo principal.

Aqui se ejecuta toda la demostracion del programa:

- se crea a Gandalf
- se muestran sus habilidades
- se hacen varios combates
- Gandalf sube a nivel 5
- Gandalf sube a nivel 10
- se prueban excepciones con `try/catch`

## 3. Donde esta cada concepto de POO

### Herencia

La herencia esta en:

- `Personaje extends Origen`
- `Enemigo extends Origen`

Eso significa que ambas clases heredan las propiedades y metodos generales de `Origen`.

### Clase abstracta

La clase abstracta es `Origen`.

Se usa para evitar repetir codigo comun en `Personaje` y `Enemigo`.

### Interfaces

Las interfaces son:

- `CombatienteInterface`
- `HabilidadInterface`

Se usan para definir reglas que deben cumplir las clases.

### Composicion

La composicion esta en `Origen`, porque guarda un arreglo de objetos `Habilidad`.

En otras palabras:

- un personaje tiene habilidades
- las habilidades viven dentro del personaje

### Manejo de excepciones

Se usa en `Origen.php` y en `index.php`.

Las excepciones se lanzan con `throw new Exception(...)` cuando:

- el personaje no conoce una habilidad
- no tiene suficiente mana
- el atacante ya fue derrotado
- el objetivo ya fue derrotado

Luego se controlan en `index.php` con:

```php
try {
    // codigo
} catch (Exception $error) {
    echo 'Excepcion controlada: ' . $error->getMessage();
}
```

## 4. Flujo general del programa

1. Se crea a Gandalf en nivel 1.
2. Gandalf aprende `Golpe Basico` y `Bola de Fuego`.
3. Se ejecuta un combate contra un `Orco`.
4. Gandalf recupera mana y sube a nivel 5.
5. Gandalf aprende `Fragmento de Hielo`.
6. Se ejecuta otro combate.
7. Gandalf recupera mana y sube a nivel 10.
8. Gandalf aprende `Impacto Electrico`.
9. Se ejecuta el combate final.
10. Al final se fuerzan errores controlados para demostrar las excepciones.

## 5. Por que el ataque es aleatorio

El profesor pidio dano aleatorio o eventos aleatorios.

Aqui la parte aleatoria esta en la seleccion de la habilidad:

- si Gandalf esta entre nivel 1 y 4, elige al azar entre las 2 habilidades disponibles
- si Gandalf esta en nivel 5, elige al azar entre 3 habilidades
- si Gandalf esta en nivel 10, elige al azar entre 4 habilidades

Eso hace que el combate no sea siempre igual.

Para que la demostracion salga igual cuando la revisen en clase, en `index.php` se usa `srand(2)`.  
Eso mantiene el uso de `rand()`, pero deja la secuencia fija para que el output sea reproducible.

## 6. Que es fijo y que es aleatorio

### Dano fijo

Cada habilidad tiene un dano base fijo:

- Golpe Basico = 20
- Bola de Fuego = 50
- Fragmento de Hielo = 4
- Impacto Electrico = 60

### Dano aleatorio

Lo aleatorio es la habilidad elegida en cada turno.

Ademas, despues de 3 ataques normales, el siguiente ataque se vuelve critico y hace el doble de dano.

## 7. Posibles preguntas del profesor

### Que es una clase abstracta

Es una clase base que no se instancia directamente.  
Solo sirve para que otras clases hereden de ella.

### Que es herencia

Es cuando una clase hija reutiliza la estructura y comportamiento de una clase padre.

### Que es composicion

Es cuando una clase contiene objetos de otra clase.  
Aqui el personaje contiene objetos `Habilidad`.

### Para que sirve una interfaz

Sirve para obligar a una clase a cumplir ciertos metodos.

### Donde se usa `try/catch`

En `index.php`, para capturar errores controlados sin romper el programa.

### Por que no hay input del usuario

Porque la tarea pidio que todo fuera predefinido.

## 8. Nota importante sobre el proyecto

Se dejo el codigo sencillo, con nombres claros y sin tecnicas avanzadas, para que sea facil de explicar en clase.

Si luego quieren cambiar valores como vida, mana o dano, solo hay que editar los constructores y las habilidades en `Personaje.php`.
