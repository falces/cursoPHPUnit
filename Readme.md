# Qué es PHPUnit

Es una librería para realizar pruebas unitarias de código.

Una prueba unitaria es aquella que se realiza sobre un único elemento del código, generalmente una función o método. En este tipo de pruebas se determinan las respuestas que debe dar una función en diferentes circunstancias.

# Instalación

## Windows

Para instalar PHPUnit es necesario tener instalado Composer, por lo que empezaremos por este software.

Descargar e instalar desde la web oficial, https://getcomposer.org/download/.

## Mac

Una vez instalado Composer, podemos crear la instalación global moviendo el ejecutable con el siguiente comando:

```bash
$ mv composer.phar /usr/local/bin/composer
```

## PHPUnit

Creamos una carpeta para un proyecto nuevo y nos situamos dentro de la carpeta:

```bash
$ mkdir cursoPHPUnit
$ cd cursoPHPUnit
```

Una vez dentro, añadimos PHPUnit:

```bash
# Ajustar la versión de PHPUnit con la configuración local:
$ composer require --dev phpunit/phpunit

# Elegir una versión:
$ composer require --dev phpunit/phpunit ^9

# Si hay errores por incompatibilidad de versiones:
$ composer require --dev phpunit/phpunit ^9 --ignore-platform-reqs
```

Si hay problemas por incompatibilidad de versiones:

```
[InvalidArgumentException]
  Package phpunit/phpunit at version ^9 has requirements incompatible with your PHP version, PHP extensions and Compo
  ser version:
    - phpunit/phpunit 9.5.10 requires php >=7.3 which does not match your installed version 5.5 (Package overridden v
  ia config.platform, actual: 7.4.3).
```

Es necesario editar la configuración de Composer. Primero ver dónde tenemos la configuración de Composer:

```bash
$ composer config --global home
```

En esta carpeta encontraremos el archivo `config.json`, donde tendremos algo como esto:

```json
{
  "config": {
    "platform": {
      "php": "5.5"
    }
  }
}
```

Quitamos la clave `platform`:

```json
{
  "config": {}
}
```

Y ejecutamos la instalación: 

```bash
$ composer require --dev phpunit/phpunit ^9
```

Una vez instalado podemos ejecutar, desde la raíz de nuestro proyecto, este comando:

```bash
$ ./vendor/phpunit/phpunit/phpunit
```

Lo que nos mostrará las opciones del comando `phpunit`. Es muy cómodo crear un alias para este comando:

```bash
# Linux / Mac
$ alias phpunit="./vendor/phpunit/phpunit/phpunit"

# Windows
$ echo @php "%~dp0vendor\phpunit\phpunit\phpunit" %* > phpunit.cmd
```

De forma que sólo ejecutando `$ phpunit` tendremos acceso al comando en cualquier proyecto. Podemos añadir el flag --color para que nos muestre color (verde/rojo) según el resultado de los tests:

```bash
$ alias phpunit="./vendor/phpunit/phpunit/phpunit --color"
```

# Configurar PHPUnit en nuestro proyecto

Es posible crear un conjunto de configuraciones para PHPUnit de ámbito exclusivo de nuestro proyecto. Para esto, creamos un archivo `phpunit.xml` en la raíz de nuestro proyecto. Podemos especificar desde parámetros como color para que se muestre el resultado resaltado hasta qué tests se deben ejecutar:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit colors="true"
         verbose="true"
         bootstrap="vendor/autoload.php">
    <testsuites>
        <testsuite name="Test suite">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

Dado que hemos especificado el directorio en el que buscar tests, si ejecutamos

```bash
$ phpunit
```

Se ejecutarán todos los *tests*. Podemos ver todas las opciones de configuración en la documentación oficial (ver capítulo Referencias). Si ahora queremos ver las opciones de PHPUnit, que antes veíamos con el comando `$ phpunit`, tenemos que añadir el flag `-h`:

```bash
$ phpunit -h
```

# Creando Tests

## Nuestro primer test

Lo primero que tenemos que hacer es crear una carpeta `tests` en la raíz de nuestro proyecto.

Dentro de esta carpeta, creamos un archivo `ExampleTest.php`.

`ExampleTest.php`

```php
<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{

}
```

Con esto ya podemos ejecutar PHPUnit:

```bash
$ phpunit tests/ExampleTest.php
# Si no has creado el alias phpunit, tienes que ejecutar:
# ./vendor/phpunit/phpunit/phpunit tests/ExampleTest.php

PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

W                                                                   1 / 1 (100%)

Time: 00:00.002, Memory: 4.00 MB

There was 1 warning:

1) Warning
No tests found in class "ExampleTest".

WARNINGS!
Tests: 1, Assertions: 0, Warnings: 1.
```

Como vemos, nos devuelve un warning diciendo que no hay ningún test en la clase. Pero ya tenemos PHPUnit funcionando.

Dentro de la case, un test individual es una función pública cuyo nombre comienza por test seguida por una descripción de lo que hace el test. Dado que no tenemos ninguna clase escrita en nuestro proyecto, creamos un sencillo test para comprobar que dos más dos da como resultado cuatro:

```php
public function testAddingTwoPlusTwoResultsInFour()
{
	
}
```

Si ejecutamos nuestro test:

```bash
$ phpunit tests/ExampleTest.php

PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

R                                                                   1 / 1 (100%)

Time: 00:00.001, Memory: 4.00 MB

There was 1 risky test:

1) ExampleTest::testAddingTwoPlusTwoResultsInFour
This test did not perform any assertions

/home/falces/Source/personal/cursoPHPUnit/tests/ExampleTest.php:7

OK, but incomplete, skipped, or risky tests!
Tests: 1, Assertions: 0, Risky: 1.
```

PHPUnit nos devuelve un mensaje diciendo que no se ha realizado ninguna *assertion* (aserción), dado que la función está vacía.

Una aserción es una comprobación que verifica que algo es verdadero en un test. Añadimos dentro de nuestra función la línea

```bash
# (expected, actual)
$this->assertEquals(4, 2 + 2);
```

Si ejecutamos el test:

```
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 00:00.002, Memory: 4.00 MB

OK (1 test, 1 assertion)
```

Vamos a cambiar el valor esperado a 5:

```
$this->assertEquals(5, 2 + 2);
```

Y ejecutamos el test, obteniendo el error en el test:

```bash
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

F                                                                   1 / 1 (100%)

Time: 00:00.002, Memory: 4.00 MB

There was 1 failure:

1) ExampleTest::testAddingTwoPlusTwoResultsInFour
Failed asserting that 4 matches expected 5.

/home/falces/Source/personal/cursoPHPUnit/tests/ExampleTest.php:9

FAILURES!
Tests: 1, Assertions: 1, Failures: 1.
```

Funciona, pero como vemos estamos únicamente ejecutando un test que no comprueba nada. Los test unitarios se han creado para comprobar nuestro código, así es que vamos a escribir código propio para luego poder probarlo.

## Nombres de los test

Los métodos de pruebas deben comenzar por `test`. Los métodos que no empiecen por `test` simplemente no se evaluarán. Si queremos ejecutar un método de test que no empieza por test, debemos añadir la anotación antes de la función:

```
/**
* @test
*/
```

Los nombres de `tests` no tienen por qué estar escritos en *camelCase*, pueden escribirse de cualquier forma, por ejemplo `under_score`, siempre que empiecen por `test` o tengan la anotación `@test`.

## Crear test para nuestro código

Vamos a crear un archivo `functions.php` con un método muy simple que devuelve la suma de dos argumentos dados:

`functions.php`

```PHP
<?php

/**
 * Return the sum of two numbers
 *
 * @param integer $a The first number
 * @param integer $b The second number
 *
 * @return integer The sum of the two numbers
 */
function add($a, $b) {

    return $a + $b;

}
```

Ahora, dentro de la carpeta tests, escribimos el test `FunctionTest.php`:

`/tests/FunctionTest.php`

```php
<?php

use PHPUnit\Framework\TestCase;

class FunctionTest extends TestCase
{
    public function testAddReturnsTheCorrectSum()
    {
        require 'functions.php';

        $this->assertEquals(4, add(2, 2));
        $this->assertEquals(8, add(3, 5));
    }
}
```

Como vemos, requerimos el archivo que contiene el método a probar (ver el apartado Autocarga de clases de este capítulo para ver cómo evitar tener que hacer esto) y luego invocamos el método `assertEquals` pero, como segundo parámetro, pasamos la llamada al método que vamos a probar con parámetros de prueba. Hacemos esto dos veces con diferentes valores. Ejecutamos el test:

```bash
$ phpunit tests/FunctionTest.php

PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 00:00.001, Memory: 4.00 MB

OK (1 test, 2 assertions)
```

Nos dice que ha ido todo ok y que hemos hecho dos aserciones. Ahora vamos a añadir una aserción para validar que un método no devuelve un valor erróneo (false). Para esto usamos *assertNotEquals*. Añadimos esta función al archivo `FunctionTest.php`:

```php
public function testAddDoesNotReturnTheIncorrectSum()
{
	$this->assertNotEquals(5, add(2, 2));
} 
```

Si ejecutamos ahora el test, obtenemos:

```
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 00:00.002, Memory: 4.00 MB

OK (2 tests, 3 assertions)
```

Si nos fijamos en la respuesta, en la segunda línea ahora vemos dos puntos en lugar de uno, esto quiere decir que hay dos funciones de test, antes teníamos una. Si rompemos uno de los test, por ejemplo el segundo, se mostraría:

```
.F
```

La lista de aserciones disponibles depende de la versión de PHPUnit utilizada, puede ser consultada en la documentación oficial (ver capítulo Referencias).

# Ejecutando tests

## El comando phpunit

Hemos configurado un alias `phpunit` para el comando `./vendor/phpunit/phpunit/phpunit`. Si ahora ejecutamos el comando `$ phpunit` podemos ver las opciones que podemos utilizar:

```bash
$ phpunit tests/UserTest.php
```

Podemos ejecutar tests sin añadir la extensión del archivo que vamos a probar:

```bash
$ phpunit tests/UserTest
```

O podemos indicar una carpeta y PHPUnit ejecutará todos los tests que encuentre:

```bash
$ phpunit tests
```

O podemos ejecutar un único método de uno de los test, esto es especialmente práctico cuando tenemos muchos test escritos y sólo queremos comprobar el funcionamiento del test en el que estamos trabajando:

```bash
$ phpunit tests --filter=testReturnsFullName
```

## Realizar tests sobre una clase

Imaginemos que tenemos una sencilla clase `User` que tiene dos propiedades (nombre y apellido) y un método que me devuelve el nombre y el apellido del usuario:

`User.php`

```php
<?php

/**
 * User
 *
 * A user of the system
 */
class User
{

    /**
     * First name
     * @var string
     */
    public $first_name;
    
    /**
     * Last name
     * @var string
     */
    public $surname;

    /**
     * Get the user's full name from their first name and surname
     *
     * @return string The user's full name
     */
    public function getFullName()
    {
        return "$this->first_name $this->surname";
    }
}
```

Ahora escribimos los tests para esta clase:

`/tests/UserTest.php`

```php
<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testReturnsFullName()
    {
        require 'User.php';

        $user = new User;

        $user->first_name = "Teresa";
        $user->surname = "Green";

        $this->assertEquals('Teresa Green', $user->getFullName());
    }

    public function testFullNameIsEmptyByDefault()
    {
        $user = new User;

        $this->assertEquals('', $user->getFullName());
    }
}
```

En el segundo método no es necesario requerir la clase User ya que la tenemos requerida en el primer método. Dado que se ejecutan en orden, no es necesario volver a requerirla. Ver el apartado Autocarga de clases de este capítulo para ver cómo evitar tener que hacer esto.

Cuando ejecutamos nuestro test, obtenemos:

```
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

.F                                                                  2 / 2 (100%)

Time: 00:00.002, Memory: 4.00 MB

There was 1 failure:

1) UserTest::testFullNameIsEmptyByDefault
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-''
+' '

/home/falces/Source/personal/cursoPHPUnit/tests/UserTest.php:23

FAILURES!
Tests: 2, Assertions: 2, Failures: 1.
```

Hay un error. Dado que nuestro método devuelve:

```php
return "$this->first_name $this->surname";
```

Aunque nombre y apellido estén vacíos, estamos devolviendo un espacio entre ambos, es decir, estamos devolviendo un espacio. El test nos dice lo que espera y lo que obtiene:

```
--- Expected
+++ Actual
@@ @@
-''
+' '
```

Ahora corregimos nuestro bug:

```php
return trim("$this->first_name $this->surname");
```

Y obtenemos:

```
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

..                                                                  2 / 2 (100%)

Time: 00:00.001, Memory: 4.00 MB

OK (2 tests, 2 assertions)
```

Nuestro test ha encontrado un bug y lo hemos corregido, por lo tanto nuestro código ha mejorado.

## Dependencias

Dado que los tests se ejecutan en orden, podemos establecer dependencias entre los métodos de test de forma que objetos generados por un test puedan ser utilizados en otro, evitando así nuevas instancias y repeticiones. Supongamos que tenemos estos dos métodos:

```php
public function testNewQueueIsEmpty()
{
    $queue = new Queue;

    $this->assertEquals(0, $queue->getCount());
}

public function testAnItemIsAddedToTheQueue(Queue $queue)
{
    $queue = new Queue;

    $queue->push('green');

    $this->assertEquals(1, $queue->getCount());
}
```

Como vemos, el método `testAnItemIsAddedToTheQueue` instancia un nuevo objeto de la clase `Queue`. Pero podemos utilizar el objeto generado en el método `testNewQueueIsEmpty`:

```php
public function testNewQueueIsEmpty()
{
    $queue = new Queue;

    $this->assertEquals(0, $queue->getCount());

    return $queue;
}

/**
* @depends testNewQueueIsEmpty
*/
public function testAnItemIsAddedToTheQueue(Queue $queue)
{
    $queue->push('green');

    $this->assertEquals(1, $queue->getCount());
}
```

Devolvemos el objeto en el primer método y lo inyectamos como argumento en el segundo, donde además hemos configurado en una anotación de qué método depende, así no tenemos que volver a instanciar el objeto en el segundo método.

El test dependiente (el que tiene la anotación, en nuestro caso el segundo) se conoce como `consumer`, mientras que el test del que se depende se conoce como `producer`.

Es una buena práctica hacer que los tests sean independientes unos de otros dado que, en ocasiones, puede resultar difícil saber de dónde vienen valores que estamos usando en nuestros tests.

## Fixtures

Antes de utilizar las dependencias, en cada método fijábamos los datos a un estado conocido antes de hacer cualquier test, por ejemplo instanciando el objeto `Queue`. Este estado previo se conoce con el nombre de Fixture del test. Para trabajar con la buena práctica de no hacer depender unos tests de otros, PHPUnit nos provee de varios métodos para fijar un estado conocido previo para cada método. Este estado se conoce como Fixture.

### setUp

Este método se ejecuta antes de cada uno de los métodos test. En él instanciaremos objetos y los asignaremos a propiedades que utilizaremos en todos los métodos del test.

### tearDown

Este método se ejecuta después de cada test. Normalmente se usa para tareas de limpieza de valores después de cada test, por ejemplo eliminar objetos y propiedades. Esto es muy práctico si tenemos muchos test con muchos objetos que consumen una gran cantidad de memoria.

Este método es especialmente útil si nuestros tests crean recursos externos como archivos o abren sockets, dado que después de ejecutar los tests podemos eliminar estos recursos.

### setUpBeforeClass / setUpAfterClass

Estos métodos se ejecutan antes y después del primer y último método del test. Estos métodos son estáticos, por lo que las propiedades que creen también deberán serlo:

```php
public static function setUpBeforeClass(): void
{
	static::$queue = new Queue();
}
```

## Excepciones

Nuestro código puede -debe- devolver excepciones cuando algo falle. Dado que cuando una excepción es devuelta la ejecución del código se para, PHPUnit nos provee un método para probar las excepciones. Este método debe escribirse justo antes de la línea que puede devolver la excepción:

```php
$this->expectException(QueueException::class);
static::$queue->push('Add this item should throw an QueueException Exception');
```

Además de las excepciones, podemos probar código y mensaje de la excepción con `expectExceptionCode()` y `expectExceptionMessage()`.

## Autocarga de clases

Cada vez que escribimos un test debemos, al menos en el primer método de la clase test, requerir la clase que vamos a probar. Podemos evitar esto si utilizamos autocarga de clases. La mejor forma de autocargar clases es usar autoload PSR-4 de Composer que, básicamente, mapea *namespaces* con carpetas.

Creamos una carpeta en la raíz de nuestro proyecto en la que tendremos nuestras clases, por ejemplo `/src` y movemos nuestra clase `User` dentro de esta carpeta.

Ahora configuramos nuestro composer.json y mapeamos la carpeta `src`, añadiendo la clave `autoload`:

```json
"autoload": {
    "psr-4": {
    	"": "src/"
    }
}
```

Ahora tenemos que generar los archivos `autoload` de Composer:

```bash
$ composer dump-autoload
Generating autoload files
Generated autoload files
```

En nuestro archivo `UserTest.php`, requerimos el autoload:

```
require 'vendor/autoload.php';
```

Podemos configurar esto para que PHPUnit lo haga directamente añadiéndolo en el flag `--bootstrap`:

```bash
$ phpunit --bootstrap="vendor/autoload.php"
```

# Test Doubles: *Mocks*

Hasta ahora hemos hecho pruebas sobre una clase que no requiere clases externas. Cada clase debería tener su set de pruebas y, al probar una clase concreta, no deberíamos depender de clases externas. Para esto PHPUnit nos provee los *Mock Objects*: objetos creados con nuestros propios valores para eliminar las dependencias de recursos y código externos.

En lugar de instanciar una clase que depende de recursos externos, lo que hacemos es crear un *Mock*: es una pseudo instancia de la clase, que tendrá todas sus propiedades y métodos, pero no habrá ejecutado ninguno (devuelven *null*).

Cuando ejecutamos algún método del *Mock* debemos informar de la respuesta: falsearemos su resultado para poder comprobar diferentes resultados. Estos métodos se conocen con el nombre de *stubs*.

## Crear un *Mock*

Supongamos que tenemos una clase `User` que, entre otras cosas, tiene un método para enviar una notificación al usuario:

`User.php`

```php
// ...
public function notify(string $message): bool
{
    return $this->mailer->sendMessage($this->email, $message); // true/false
}
// ...
```

Y una clase para enviar notificaciones:

`Mailer.php`

```php
// ...
public function sendMessage(
    string $email,
    string $message): bool
{
    // Usamos mail() o PHP Mailer...
    sleep(3);
    echo "send '$message' to '$email'";
    return true;
}
// ...
```

Dado que no vamos a enviar un mensaje cada vez que realicemos un test, creamos un *Mock* en su test:

`UserTest.php`

```php
// ...
public function testNotificationIsSent()
{
    static::$user->email = 'john.doe@company.com';

    // Para no enviar mensajes cada vez que hacemos un test, creamos un Mock de la clase Mailer:
    $mockMailer = $this->createMock(Mailer::class);

    // Configuración: que se llame una vez al método sendMessage, que los parámetros sean los indicados y que devuelva true
    $mockMailer
        ->expects($this->once())
        ->method('sendMessage')
        ->with('john.doe@company.com', "Hello")
        ->willReturn(true);

    static::$user->setMailer($mockMailer);

    $this->assertTrue(static::$user->notify("Hello"));
}
// ...
```

## Configurar un *Mock*

Con el método `getMockBuilder` podemos crear un *Mock* y personalizarlo según nuestras necesidades. Internamente, el método `createMock` invoca a `getMockBuilder` pero con una serie de configuraciones por defecto (best-practices):

`TestCase.php`

```php
protected function createMock($originalClassName)
{
    return $this->getMockBuilder($originalClassName)
                ->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();
}
```

Supongamos que tenemos esta clase con un método que saluda diferente según el idioma del usuario:

`Users.php`

```php
<?php

class Users
{
    public $db = null;
    
    function __construct(UsersDatabase $db) 
    {
        $this->db = $db;
    }
    
    public function greeting($id)
    {
        $user = $this->db->getUserByID($id);
        $userName = $user->name;
        
        switch($user->language){
            case "ES":
                $greeting = "Hola, ";
                break;
            case "EN":
            default:
                $greeting = "Hello, ";
        }
        
        return $greeting . $userName;
    }
}
```

Tenemos la clase `UsersDatabase` para consultar la base de datos:

`UsersDatabase.php`

```php
<?php

class UsersDatabase
{
    public function getUserByID($id)
    {
        return sql("select name, language from users where id = $id limit 1;")[0];
    }
}
```

Ahora vamos con el test para la clase `Users`. No queremos probar la clase `UsersDatabase`, de hecho no nos importa qué hace, sólo nos importa que la instrucción `$person->greeting(1)` devuelve, por ejemplo, "Hola, Javi". El test sin *Mock* sería algo parecido a esto:

`UsersTest.php`

```php
<?php
require __DIR__ . '/Users.php';
require __DIR__ . '/UsersDatabase.php';
use PHPUnit\Framework\TestCase;
class UsersTest extends TestCase
{
    public function testGreeting()
    {
        $db = new UsersDatabase();
        $user = new Users($db);
        $this->assertEquals('Hola, Javi', $user->greeting(1));
    }
}
```

Para evitar hacer cualquier tipo de consulta a la base de datos, creamos un *Mock* de la clase `UsersDatabase` dentro de nuestro test:

`UsersTest.php`

```php
<?php
require __DIR__ . '/Users.php';
require __DIR__ . '/UsersDatabase.php';
use PHPUnit\Framework\TestCase;
class UsersTest extends TestCase
{
    public function testGreeting()
    {
        // Creamos el objeto de base de datos, indicando al MockBuilder que usaremos el método getUserByID después:
        $dbMock = $this->getMockBuilder(UsersDatabase::class)
            ->setMethods(['getUserByID'])
            ->getMock();
        
        // Creamos un objeto con los datos que devolvería la base de datos:
        $mockUser = new stdClass();
	    $mockUser->name    = 'Javi';
        $mockUser->language = 'ES';
        
        // Ahora indicamos a la clase Mock que nos devuelva el usuario que acabamos de crear:
        $dbMock->method('getUserByID')->willReturn($mockUser);
        
        // Y pasamos esta respuesta a la clase que estamos probando:
	    $testUser = new Users($dbMock);
        
        // Comprobamos que nuestro método hace lo que tiene que hacer (añadir el saludo en su idioma) y devuevle el texto correcto:
        $this->assertEquals('Hola, Javi', $testUser->greeting(1));
    }
}
```

Otro ejemplo claro son las clases que, en algún momento de su ejecución envían algún mensaje. No queremos que cada vez que ejecutemos un test se envíe un mensaje, por lo que crearemos un *Mock* del objeto que envíe el mensaje y lo utilizaremos.

Cuando creamos un *Mock* también podemos configurar comportamientos que esperamos. Si tenemos el *Mock*:

```php
$mockMailer->method('sendMessage')
            ->willReturn(true);
```

Podríamos cambiar el método:

```php
public function notify(string $message): bool
{
    return $this->mailer->sendMessage($this->email, $message);
}
```

Por:

```php
public function notify(string $message): bool
{
	return true;
}
```

Y el test funcionaría igual, ya que no valida que se invoque el método `sendMessage` dentro de `notify`. Cambiamos la configuración del *Mock*:

```php
$mockMailer
    ->expects($this->once())
    ->method('sendMessage')
    ->willReturn(true);
```

Con esto nos estamos asegurando de que el método `sendMessage` se invoca en `notify` una sola vez. Existen diferentes métodos para configurar el número de veces que un método es invocado, debes consultar la documentación.

También podemos validar con aserciones los valores de los argumentos en pasamos al método *stub*:

```php
$mockMailer
    ->expects($this->once())
    ->method('sendMessage')
    ->with('john.doe@company.com', "Hello")
    ->willReturn(true);
```

Cuando creamos un Mock de una clase, todos sus métodos se convierten en métodos stub. Esto quiere decir que se crean vacíos, no ejecutan ningún código y devuelven *null*. Con `getMockBuilder` podemos indicar que ciertos métodos no se conviertan en stub y ejecuten su código original:

```php
// Usar código original de todos los métodos:
$mockMailer = $this->getMockBuilder(Mailer::class)
    ->setMethods(null)
    ->getMock();

// Vaciar sólo el método sendMessage:
$mockMailer = $this->getMockBuilder(Mailer::class)
    ->setMethods(['sendMessage'])
    ->getMock();
```

## Crear Mock de dependencias que aún no existen

Hasta ahora hemos creado *Mocks* de dependencias que tenemos desarrolladas. En ocasiones, podemos necesitar crear un *Mock* de una clase externa que todavía no está desarrollada. Supongamos que tenemos una clase `Order` que depende de una pasarela de pago `PaymentGateway` que todavía no está desarrollada.

No podemos usar `createMock` para crear un *Mock* de una clase que no está desarrollada, para esto necesitamos `getMockBuilder`:

`Order.php`

```php
<?php

class Order
{
    public $amount = 0;
    protected $gateway;

    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function process()
    {
        return $this->gateway->charge($this->amount);
    }
}
```

Crearíamos su test creando un *Mock* de `PaymentGateway`. Dado que la clase no existe, configuraremos todos los métodos que necesitemos:

```php
// ...
public function testProcess()
    {
        // Configuración de la clase PaymentGateway
        $paymentGateway = $this->getMockBuilder('PaymentGateway')
            ->setMethods(['charge'])
            ->getMock();
    
        // Configuración del método charge
        $paymentGateway->method('charge')
            ->willReturn(true);

        $order = new Order($paymentGateway);
        $order->amount = 200;
        $this->assertTrue($order->process());
    }
// ...
```

Podemos ampliar y mejorar la configuración del método, en este caso indicamos que sea invocado una única vez y que como parámetro reciba el valor 200:

```php
// ...
$paymentGateway
    ->expects($this->once())
    ->method('charge')
    ->with(200)
    ->willReturn(true);
// ...
```

# Mockery

Aunque la funcionalidad de PHPUnit para trabajar con *Mocks* es muy completa, podemos utilizar librerías externas más especializadas. La más común para trabajar con PHPUnit es Mockery, que ofrece una forma diferente de definir y configurar *Mocks*, además de dar funcionalidad que PHPUnit no ofrece.

## Instalación

```bash
$ composer require mockery/mockery --dev
```

## Integración

Dependiendo del contexto de la prueba donde vayamos a utilizar Mockery, podemos elegir entre dos formas de utlizar la librería:

### Método tearDown

Podemos utilizar *Mockery* simplemente añadiendo un método `tearDown` (se ejecuta al final de cada método test):

```php
<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }
}
```

### Usando MockeryTestCase

Extendemos nuestro test de `MockeryTestCase` en lugar de `TestCase`:

`ExampleTest.php`

```php
<?php

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ExampleTest extends MockeryTestCase
{

}
```

## Comparando con *Mocks* de PHPUnit

Tenemos una clase WeatherMonitor con un método que devuelve la temperatura media entre dos horas recibidas:

```php
// ...
public function getAverageTemperature(string $start, string $end)
{
    $start_temp = $this->temperatureService->getTemperature($start);
    $end_temp = $this->temperatureService->getTemperature($end);

    return ($start_temp + $end_temp) / 2;
}
// ...
```

Este método usa el servicio `temperatureService`, recibido en el constructor, y tiene un método getTemperature que devuelve una temperatura para una hora dada:

```php
// ...
public function getTemperature(string $time): int
{
	// ...
}
// ...
```

### PHPUnit

Este método no lo queremos invocar durante nuestros tests, así es que en el test creamos un `valueMap`, un array en el que cada elemento es una dupla parámetro - respuesta. En el método `will` pasamos este array como parámetro del método `returnValueMap`: El test sería así:

```php
// ...
public function testCorrectAverageIsReturned()
{
    $temperatureService = $this->createMock(TemperatureService::class);

    // Array con los valores que devolverá el método
    $valueMap = [
        ['10:00', 19],
        ['12:00', 20],
        ['14:00', 26],
        ['16:00', 49],
    ];

    $temperatureService
        ->expects($this->exactly(2))
        ->method('getTemperature')
        ->will($this->returnValueMap($valueMap));

    $weatherMonitor = new WeatherMonitor($temperatureService);

    $this->assertEquals(34, $weatherMonitor->getAverageTemperature('10:00', '16:00'));
}
// ...
```

### Mockery

Con Mockery la legibilidad mejora dado que los métodos son más sintácticos y tenemos aislados el parámetro que se envía y el valor de retorno:

```php
// ...
public function testCorrectAverageIsReturnedWithMockery()
{
    $temperatureService = Mockery::mock(TemperatureService::class);

    $temperatureService
        ->shouldReceive('getTemperature')
        ->once()
        ->with('12:00')
        ->andReturn(20);

    $temperatureService
        ->shouldReceive('getTemperature')
        ->once()
        ->with('14:00')
        ->andReturn(26);

    $weatherMonitor = new WeatherMonitor($temperatureService);
    $this->assertEquals(23, $weatherMonitor->getAverageTemperature('12:00', '14:00'));
}
// ...
```

## Spies

Una de las funcionalidades que ofrece Mockery que no tiene PHPUnit son los *spies*. En esencia son como los *Mocks* pero, mientras que en los *Mocks* tenemos que determinar lo que esperamos antes de la ejecución, en los *spies* podemos determinarlo después de la ejecución. Los spies almacenan el resultado de cualquier interacción entre el spy y el SUT (Sistem Under Test) y nos permite hacer aserciones sobre esos resultados.

Tenemos una clase `NewOrder` que en el constructor recibe dos parámetros, unidades y cantidad y calcula una tercera propiedad multiplicándolas. También tiene un método `process` que recibe una pasarela de pago e invoca el método `charge` de dicha pasarela. No tenemos desarrollada la clase de la pasarela. Creamos los test:

### Test con Mock

```php
// ...
public function testOrderIsProcessedUsingAMock()
{
    $order = new NewOrder(3, 1.99);

    $this->assertEquals(5.97, $order->amount);

    $gatewayPaymentMock = Mockery::mock('PaymentGateway');
    $gatewayPaymentMock
        ->shouldReceive('charge')
        ->once()
        ->with(5.97);

    $order->process($gatewayPaymentMock);
}
// ...
```

### Test con Spy

```php
// ...
public function testOrderIsProcessedUsingASpy()
{
    $order = new NewOrder(3, 1.99);

    $this->assertEquals(5.97, $order->amount);

    $gatewayPaymentSpy = Mockery::spy('PaymentGateway');

    $order->process($gatewayPaymentSpy);

    $gatewayPaymentSpy
        ->shouldHaveReceived('charge')
        ->once()
        ->with(5.97);
}
// ...
```

Como vemos, primero ejecutamos la acción y luego validamos lo que ha sucedido.

# Referencias

## PHPUnit

- Página oficial: https://phpunit.de/
- Documentación: https://phpunit.readthedocs.io/

## Mockery

- Documentación oficial: http://docs.mockery.io/en/latest/
- Integración con PHPUnit: http://docs.mockery.io/en/latest/reference/phpunit_integration.html
- Repositorio: https://github.com/mockery/mockery
- Creating Test Doubles: http://docs.mockery.io/en/latest/reference/creating_test_doubles.html
