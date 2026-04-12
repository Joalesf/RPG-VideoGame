# Documentacion Tecnica Actual Del Proyecto

## 1. Proposito de este documento

Este documento explica la version actual del repositorio tal como esta hoy.

La idea es que sirva para:

- entender la arquitectura real del codigo
- explicar con seguridad que hace cada archivo
- poder defender el proyecto frente al profesor
- no confundir la version actual con versiones anteriores

Importante: esta documentacion describe el estado actual del repo, no una version idealizada.

## 2. Radiografia tecnica del proyecto actual

### Archivos principales

- `index.php`
- `Personaje.php`
- `Enemigo.php`
- `Habilidad.php`
- `Ronda_Ataque.php`

### Estructura general

La ejecucion empieza en `index.php`.

Desde ahi:

1. Se define una clase abstracta llamada `Origen`.
2. Se cargan las clases `Personaje`, `Enemigo`, `Ronda_Ataque` y `Habilidad`.
3. Se crea un personaje.
4. Se crea un enemigo.
5. Se inicia el combate.
6. El combate sigue por rondas hasta que uno de los dos llegue a 0 de vida.

### Conceptos de POO que si aparecen en esta version

- Clase abstracta: `Origen`
- Herencia: `Personaje extends Origen`
- Composicion: `Personaje` y `Enemigo` contienen un objeto `Habilidad`
- Encapsulacion parcial: varias propiedades son `private` o `protected`
- Manejo de excepciones: `throw new Exception(...)` y `try/catch`

### Conceptos que estaban en versiones anteriores o en el enunciado, pero no aparecen realmente en esta version

- No hay interfaces en el codigo actual
- El enemigo actual no hereda de `Origen`
- El critico no ocurre cada 3 ataques: ocurre con probabilidad 50%
- El dano critico no es x2: en esta version es x4
- Las habilidades no se desbloquean solo en nivel 5 y 10: aqui se desbloquean desde el nivel 2 hasta el 10

## 3. Que hace realmente el sistema actual

### Personaje

El personaje inicia por defecto como `Gandalf` con:

- vida = 200
- mana = 150
- nivel = 1
- experiencia = 0

Tambien recibe un manejador de habilidades (`Habilidad`) para obtener sus habilidades iniciales.

### Habilidades del personaje

Al inicio tiene 2 habilidades base:

- `Golpe Basico`, dano 20, mana 0
- `Bola de Fuego`, dano 50, mana 30

Luego, al subir de nivel, puede aprender nuevas habilidades desde nivel 2 hasta nivel 10.

### Enemigo

El enemigo por defecto es `Orco` con:

- vida = 500

Tambien obtiene un conjunto de habilidades propias del enemigo:

- `Ataque Fisico`, dano 30
- `Lanzar Piedra`, dano 50

### Sistema de combate

La clase `Ronda_Ataque` controla el combate.

En cada ronda:

1. El personaje ataca con una habilidad aleatoria.
2. Gana 25 puntos de experiencia.
3. Mientras tenga 13 o mas de experiencia, sube de nivel.
4. Si el enemigo sigue vivo, el enemigo ataca con una habilidad aleatoria.
5. Se pasa a la siguiente ronda.

### Dano critico

El dano critico funciona asi:

- se genera con `rand(1, 2)`
- si sale `1`, hay critico
- el dano se multiplica por `4`

Eso significa que el critico tiene un 50% de probabilidad.

### Mana

Si la habilidad elegida aleatoriamente necesita mas mana del que el personaje tiene:

- el sistema fuerza el uso de `Golpe Basico`

Despues del ataque, el mana se reduce segun el costo de la habilidad usada.

## 4. Observaciones tecnicas importantes para la defensa

Estas observaciones son muy importantes para hablar con autoridad y no decir algo incorrecto.

### Observacion 1

La clase abstracta `Origen` solo guarda `experiencia`.

No guarda vida, mana, nombre o habilidades.

Eso significa que la herencia existe, pero esta siendo usada de forma minima.

### Observacion 2

`Personaje` si hereda de `Origen`, pero `Enemigo` no.

Si el profesor pregunta si ambos heredan de una misma base, la respuesta honesta es:

"En esta version actual del repo, solo `Personaje` hereda de `Origen`; `Enemigo` es una clase independiente."

### Observacion 3

La composicion si esta presente.

Se ve cuando `Personaje` crea:

```php
$this->habilidadesManager = new Habilidad();
```

Y cuando `Enemigo` hace lo mismo.

Eso significa que esas clases dependen de un objeto de otra clase para manejar habilidades.

### Observacion 4

El sistema de excepciones si existe.

Se ve aqui:

- `Personaje::recibirDaño()` lanza una excepcion si el personaje ya esta derrotado
- `Ronda_Ataque::iniciarCombate()` captura esa excepcion con `catch`

### Observacion 5

El metodo `Enemigo::getDañoBase()` devuelve `$this->dañoBase`, pero esa propiedad no existe en la clase.

La realidad tecnica es:

- el metodo esta definido
- pero no esta respaldado por una propiedad valida
- ademas, en la ejecucion actual ese metodo no se usa

Si el profesor lo nota, pueden decir:

"Ese metodo quedo definido, pero el dano real del enemigo sale del arreglo de habilidades y no de una propiedad individual."

### Observacion 6

El programa imprime HTML como:

- `<h2>`
- `<br>`
- `<strong>`

Por eso se ve mejor en navegador que en consola.

## 5. Flujo completo de ejecucion

1. `index.php` define la clase abstracta `Origen`.
2. `index.php` carga los demas archivos con `require_once`.
3. Se imprime el titulo del combate.
4. Se crea un objeto `Personaje`.
5. Se crea un objeto `Enemigo`.
6. Se crea un objeto `Ronda_Ataque`.
7. Se llama `iniciarCombate($personaje, $enemigo)`.
8. El personaje ataca con una habilidad aleatoria.
9. Gana experiencia.
10. Puede subir varios niveles en la misma ronda.
11. Aprende habilidades nuevas segun el nivel.
12. Si el enemigo sigue con vida, ataca.
13. El ciclo continua hasta que uno llegue a 0 de vida.
14. Se imprime `Victoria` o `Derrota`.
15. Se imprime `Fin del Combate`.

## 6. Guia de defensa oral

Si el profesor pregunta "como esta estructurado el proyecto", una respuesta corta y tecnica puede ser esta:

"El proyecto esta dividido en cinco archivos principales. `index.php` arranca el sistema y define la clase abstracta `Origen`, que en esta version maneja la experiencia. `Personaje` hereda de `Origen` y contiene vida, mana, nivel y un manejador de habilidades. `Enemigo` es una clase separada con vida y habilidades propias. `Habilidad` funciona como repositorio de habilidades del personaje y del enemigo. `Ronda_Ataque` controla el combate por rondas, la seleccion aleatoria de habilidades, los criticos, la experiencia y la subida de nivel."

Si el profesor pregunta "donde esta la composicion", la respuesta puede ser:

"La composicion esta en `Personaje` y `Enemigo`, porque ambas clases crean y guardan un objeto `Habilidad` para obtener sus habilidades."

Si el profesor pregunta "donde esta la herencia", la respuesta puede ser:

"La herencia esta entre `Personaje` y `Origen`. En esta version actual, `Enemigo` no hereda de `Origen`."

Si el profesor pregunta "donde estan las excepciones", la respuesta puede ser:

"La excepcion se lanza en `Personaje::recibirDaño()` cuando el personaje ya esta derrotado, y luego se captura con `try/catch` en `Ronda_Ataque`."

Si el profesor pregunta "como funcionan los ataques aleatorios", la respuesta puede ser:

"Se usa `array_rand()` para elegir una habilidad aleatoria del arreglo de habilidades. Luego se usa `rand(1, 2)` para decidir si ese ataque sera critico."

## 7. Explicacion linea por linea

---

## Archivo: `index.php`

Linea 1: Abre el bloque PHP.
Linea 2: Comentario que identifica la seccion de integrantes.
Linea 3: Nombre del integrante Richard Rdriguez.
Linea 4: Nombre del integrante Edgar Rosario.
Linea 5: Nombre del integrante Jose Sanchez.
Linea 6: Nombre del integrante Leonardo Liang.
Linea 7: Linea en blanco para separar.
Linea 8: Declara la clase abstracta `Origen`.
Linea 9: Define la propiedad publica `experiencia` con valor inicial 0.
Linea 10: Linea en blanco.
Linea 11: Declara el constructor de `Origen`.
Linea 12: Guarda el valor recibido en la propiedad `experiencia`.
Linea 13: Cierra el constructor.
Linea 14: Cierra la clase abstracta.
Linea 15: Linea en blanco.
Linea 16: Carga el archivo `Personaje.php`.
Linea 17: Carga el archivo `Enemigo.php`.
Linea 18: Carga el archivo `Ronda_Ataque.php`.
Linea 19: Carga el archivo `Habilidad.php`.
Linea 20: Linea en blanco.
Linea 21: Imprime el encabezado "Inicio del Combate RPG" usando HTML.
Linea 22: Crea un objeto `Personaje` con valores por defecto.
Linea 23: Crea un objeto `Enemigo` con valores por defecto.
Linea 24: Linea en blanco.
Linea 25: Crea un objeto `Ronda_Ataque`.
Linea 26: Inicia el combate pasando personaje y enemigo.
Linea 27: Linea en blanco.
Linea 28: Imprime el encabezado final "Fin del Combate" y cierra PHP.

---

## Archivo: `Personaje.php`

Linea 1: Abre PHP.
Linea 2: Declara la clase `Personaje` heredando de `Origen`.
Linea 3: Propiedad privada para guardar el manejador de habilidades.
Linea 4: Propiedad protegida `vida`.
Linea 5: Propiedad privada `nombre`.
Linea 6: Propiedad protegida `mana`.
Linea 7: Propiedad privada `habilidades`.
Linea 8: Propiedad privada `nivel`.
Linea 9: Linea en blanco.
Linea 10: Declara el constructor del personaje con valores por defecto.
Linea 11: Crea un objeto `Habilidad` y lo guarda en `habilidadesManager`.
Linea 12: Obtiene las habilidades iniciales y las guarda en `habilidades`.
Linea 13: Guarda el nombre recibido.
Linea 14: Guarda la vida recibida.
Linea 15: Guarda el mana recibido.
Linea 16: Guarda el nivel recibido.
Linea 17: Llama al constructor de la clase padre `Origen`.
Linea 18: Cierra el constructor.
Linea 19: Linea en blanco.
Linea 20: Declara el metodo `newhabilidad`.
Linea 21: Le pide al manejador `Habilidad` agregar una nueva habilidad segun el nivel y el nombre.
Linea 22: Actualiza el arreglo local de habilidades despues de agregar una nueva.
Linea 23: Cierra el metodo.
Linea 24: Linea en blanco.
Linea 25: Declara el metodo `recibirDaño`.
Linea 26: Verifica si el personaje ya esta derrotado.
Linea 27: Si ya esta derrotado, lanza una excepcion.
Linea 28: Cierra el `if`.
Linea 29: Resta el dano recibido a la vida actual.
Linea 30: Verifica si la vida quedo por debajo de 0.
Linea 31: Si quedo negativa, la corrige y la deja en 0.
Linea 32: Cierra ese `if`.
Linea 33: Imprime el dano recibido y la vida restante.
Linea 34: Verifica si la vida llego exactamente a 0.
Linea 35: Si la vida es 0, imprime el mensaje de derrota.
Linea 36: Cierra el `if`.
Linea 37: Cierra el metodo `recibirDaño`.
Linea 38: Linea en blanco.
Linea 39: Declara el metodo `subirNivel`.
Linea 40: Aumenta el nivel en 1.
Linea 41: Imprime el nuevo nivel.
Linea 42: Llama a `newhabilidad` para intentar agregar la habilidad correspondiente al nuevo nivel.
Linea 43: Cierra el metodo.
Linea 44: Linea en blanco.
Linea 45: Declara el getter `getNombre`.
Linea 46: Devuelve el nombre del personaje.
Linea 47: Cierra el metodo.
Linea 48: Linea en blanco.
Linea 49: Declara el getter `getVida`.
Linea 50: Devuelve la vida.
Linea 51: Cierra el metodo.
Linea 52: Linea en blanco.
Linea 53: Declara el getter `getMana`.
Linea 54: Devuelve el mana.
Linea 55: Cierra el metodo.
Linea 56: Linea en blanco.
Linea 57: Declara el metodo `reduceMana`.
Linea 58: Resta del mana el valor recibido.
Linea 59: Verifica si el mana quedo negativo.
Linea 60: Si quedo negativo, lo corrige a 0.
Linea 61: Cierra el `if`.
Linea 62: Cierra el metodo.
Linea 63: Linea en blanco.
Linea 64: Declara el getter `getNivel`.
Linea 65: Devuelve el nivel.
Linea 66: Cierra el metodo.
Linea 67: Linea en blanco.
Linea 68: Declara el getter `getHabilidades`.
Linea 69: Devuelve el arreglo de habilidades.
Linea 70: Cierra el metodo.
Linea 71: Cierra la clase `Personaje`.
Linea 72: Linea en blanco.
Linea 73: Cierra PHP.

---

## Archivo: `Enemigo.php`

Linea 1: Abre PHP.
Linea 2: Carga el archivo `Habilidad.php`.
Linea 3: Declara la clase `Enemigo`.
Linea 4: Propiedad privada `nombre` con valor inicial "Orco".
Linea 5: Propiedad privada `vida`.
Linea 6: Propiedad privada `habilidades`.
Linea 7: Propiedad privada `habilidadesManager`.
Linea 8: Linea en blanco.
Linea 9: Declara el constructor del enemigo.
Linea 10: Guarda el nombre recibido.
Linea 11: Guarda la vida recibida.
Linea 12: Crea un objeto `Habilidad` para usarlo como manejador.
Linea 13: Obtiene las habilidades del enemigo desde el manejador.
Linea 14: Cierra el constructor.
Linea 15: Linea en blanco.
Linea 16: Declara el metodo `recibirDaño`.
Linea 17: Resta a la vida el dano recibido.
Linea 18: Verifica si la vida quedo menor que 0.
Linea 19: Si quedo menor que 0, la corrige a 0.
Linea 20: Cierra el `if`.
Linea 21: Imprime el dano recibido y la vida restante.
Linea 22: Verifica si la vida llego a 0.
Linea 23: Si la vida es 0, imprime el mensaje de derrota.
Linea 24: Cierra el `if`.
Linea 25: Cierra el metodo.
Linea 26: Linea en blanco.
Linea 27: Declara el getter `getVida`.
Linea 28: Devuelve la vida actual.
Linea 29: Cierra el metodo.
Linea 30: Linea en blanco.
Linea 31: Declara el metodo `getDañoBase`.
Linea 32: Intenta devolver una propiedad `dañoBase` que no existe en esta clase.
Linea 33: Cierra el metodo.
Linea 34: Declara el getter `getNombre`.
Linea 35: Devuelve el nombre del enemigo.
Linea 36: Cierra el metodo.
Linea 37: Linea en blanco.
Linea 38: Declara el getter `getHabilidades`.
Linea 39: Devuelve el arreglo de habilidades del enemigo.
Linea 40: Cierra el metodo.
Linea 41: Cierra la clase `Enemigo`.
Linea 42: Cierra PHP.

---

## Archivo: `Habilidad.php`

Linea 1: Abre PHP.
Linea 2: Declara la clase `Habilidad`.
Linea 3: Declara la propiedad privada `habilidades` como arreglo.
Linea 4: Primera habilidad base del personaje: Golpe Basico.
Linea 5: Segunda habilidad base del personaje: Bola de Fuego.
Linea 6: Cierra el arreglo base del personaje.
Linea 7: Linea en blanco.
Linea 8: Declara la propiedad privada `habilidadesEnemigo`.
Linea 9: Primera habilidad base del enemigo: Ataque Fisico.
Linea 10: Segunda habilidad base del enemigo: Lanzar Piedra.
Linea 11: Cierra el arreglo del enemigo.
Linea 12: Linea en blanco.
Linea 13: Linea en blanco adicional.
Linea 14: Declara el metodo `getHabilidades`.
Linea 15: Devuelve el arreglo de habilidades del personaje.
Linea 16: Cierra el metodo.
Linea 17: Linea en blanco.
Linea 18: Declara el metodo `getHabilidadesEnemigo`.
Linea 19: Devuelve el arreglo de habilidades del enemigo.
Linea 20: Cierra el metodo.
Linea 21: Linea en blanco.
Linea 22: Declara el metodo `addHabilidad`.
Linea 23: Inicia un `switch` basado en el nivel.
Linea 24: Caso para nivel 2.
Linea 25: Agrega la habilidad `temblor`.
Linea 26: Imprime que el personaje aprendio `temblor`.
Linea 27: Sale del caso 2.
Linea 28: Caso para nivel 3.
Linea 29: Agrega la habilidad `Bullying`.
Linea 30: Imprime que el personaje aprendio `Bullying`.
Linea 31: Sale del caso 3.
Linea 32: Caso para nivel 4.
Linea 33: Agrega la habilidad `Chorro de Agua`.
Linea 34: Imprime que el personaje aprendio `Chorro de Agua`.
Linea 35: Sale del caso 4.
Linea 36: Caso para nivel 5.
Linea 37: Agrega la habilidad `Fragmento de Hielo`.
Linea 38: Imprime que el personaje aprendio `Fragmento de Hielo`.
Linea 39: Sale del caso 5.
Linea 40: Caso para nivel 6.
Linea 41: Agrega la habilidad `Rayo de Trueno`.
Linea 42: Imprime que el personaje aprendio `Rayo de Trueno`.
Linea 43: Sale del caso 6.
Linea 44: Caso para nivel 7.
Linea 45: Agrega la habilidad `Ilusion con ella`.
Linea 46: Imprime un mensaje que muestra `Ilusion`, aunque el nombre almacenado es `Ilusion con ella`.
Linea 47: Sale del caso 7.
Linea 48: Caso para nivel 8.
Linea 49: Agrega la habilidad `Lluvia de Meteoritos`.
Linea 50: Imprime que el personaje aprendio `Lluvia de Meteoritos`.
Linea 51: Sale del caso 8.
Linea 52: Caso para nivel 9.
Linea 53: Agrega la habilidad `Tornado de fuego`.
Linea 54: Imprime que el personaje aprendio `Tornado de fuego`.
Linea 55: Sale del caso 9.
Linea 56: Caso para nivel 10.
Linea 57: Agrega la habilidad `Las mentira de ella` con dano extremadamente alto.
Linea 58: Imprime que el personaje aprendio esa habilidad.
Linea 59: Sale del caso 10.
Linea 60: Linea en blanco con espacios.
Linea 61: Caso por defecto.
Linea 62: Imprime que no hay nuevas habilidades para ese nivel.
Linea 63: Sale del caso por defecto.
Linea 64: Cierra el `switch`.
Linea 65: Cierra el metodo `addHabilidad`.
Linea 66: Cierra la clase `Habilidad`.
Linea 67: Cierra PHP.

---

## Archivo: `Ronda_Ataque.php`

Linea 1: Abre PHP.
Linea 2: Declara la clase `Ronda_Ataque`.
Linea 3: Declara el metodo `iniciarCombate`.
Linea 4: Inicializa la ronda en 1.
Linea 5: Inicia un `while` que se ejecuta mientras ambos tengan vida mayor que 0.
Linea 6: Imprime el numero de ronda usando HTML.
Linea 7: Linea en blanco.
Linea 8: Comentario indicando que ahora ataca el personaje.
Linea 9: Llama al metodo `atacar`.
Linea 10: Suma 25 puntos de experiencia al personaje.
Linea 11: Inicia un `while` para revisar si la experiencia ya alcanza para subir nivel.
Linea 12: Si alcanza, sube un nivel.
Linea 13: Resta 13 puntos de experiencia despues de cada subida.
Linea 14: Cierra el `while` interno.
Linea 15: Linea en blanco.
Linea 16: Verifica si el enemigo sigue con vida.
Linea 17: Comentario indicando que el enemigo atacara con una habilidad aleatoria.
Linea 18: Obtiene el arreglo de habilidades del enemigo.
Linea 19: Elige una habilidad aleatoria del enemigo con `array_rand`.
Linea 20: Guarda el dano base de la habilidad elegida.
Linea 21: Imprime que el enemigo uso esa habilidad y cuanto dano hizo.
Linea 22: Abre un bloque `try`.
Linea 23: Le aplica el dano al personaje.
Linea 24: Si ocurre un error, entra al `catch`.
Linea 25: Imprime el mensaje de la excepcion.
Linea 26: Cierra el `catch`.
Linea 27: Cierra el `if`.
Linea 28: Linea en blanco.
Linea 29: Incrementa la ronda en 1.
Linea 30: Imprime un salto visual.
Linea 31: Cierra el `while` principal.
Linea 32: Linea en blanco.
Linea 33: Verifica si el personaje termino vivo.
Linea 34: Si sigue vivo, imprime el mensaje de victoria.
Linea 35: Si no, entra al `else`.
Linea 36: Imprime el mensaje de derrota.
Linea 37: Cierra el `if/else`.
Linea 38: Cierra el metodo `iniciarCombate`.
Linea 39: Linea en blanco.
Linea 40: Declara el metodo `atacar`.
Linea 41: Obtiene las habilidades actuales del personaje.
Linea 42: Elige una habilidad aleatoria del personaje con `array_rand`.
Linea 43: Linea en blanco.
Linea 44: Comentario que explica la validacion de mana.
Linea 45: Verifica si el personaje tiene menos mana del que cuesta la habilidad elegida.
Linea 46: Si no tiene suficiente mana, fuerza la habilidad posicion 0, que se asume es Golpe Basico.
Linea 47: Imprime que no tiene mana suficiente y que usara Golpe Basico.
Linea 48: Cierra el `if`.
Linea 49: Linea en blanco.
Linea 50: Guarda el dano base de la habilidad.
Linea 51: Genera un numero aleatorio para decidir si hay critico.
Linea 52: Si hay critico, multiplica el dano por 4.
Linea 53: Imprime el mensaje de golpe critico.
Linea 54: Cierra el `if`.
Linea 55: Linea en blanco.
Linea 56: Reduce el mana del personaje segun el costo de la habilidad.
Linea 57: Linea en blanco.
Linea 58: Comentario indicando que ahora se reducira la vida del enemigo.
Linea 59: Imprime que habilidad uso el personaje y cuanto dano causo.
Linea 60: Llama a `recibirDaño` del enemigo para aplicarle el dano.
Linea 61: Cierra el metodo `atacar`.
Linea 62: Cierra la clase `Ronda_Ataque`.
Linea 63: Linea en blanco.
Linea 64: Cierra PHP.

## 8. Conclusiones tecnicas

### Lo mas fuerte del proyecto actual

- El flujo del combate esta claro
- El sistema si tiene aleatoriedad
- Hay herencia real entre `Personaje` y `Origen`
- Hay composicion con la clase `Habilidad`
- Hay subida de nivel y desbloqueo de habilidades
- Hay manejo de excepciones

### Lo que conviene admitir si el profesor pregunta con detalle

- En esta version actual no se usan interfaces
- `Enemigo` no hereda de `Origen`
- El critico es x4 y 50 por ciento aleatorio
- `getDañoBase()` en `Enemigo` no esta conectado a una propiedad valida
- La logica actual de experiencia permite subir varios niveles en una sola ronda

### Frase final recomendada para cerrar la explicacion

"La version actual del proyecto esta orientada a un combate RPG por rondas, con herencia en el personaje, composicion para manejar habilidades, aleatoriedad en ataques, manejo de excepciones y crecimiento del personaje mediante experiencia y niveles. Tecnica y funcionalmente, el corazon del sistema esta en la interaccion entre `Personaje`, `Habilidad` y `Ronda_Ataque`."
