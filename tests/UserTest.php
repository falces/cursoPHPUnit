<?php

use PHPUnit\Framework\TestCase;

//require 'vendor/autoload.php';

class UserTest extends TestCase
{
    protected static User $user;

    public static function setUpBeforeClass(): void
    {
        static::$user = new User;
    }

    protected function setUp(): void
    {
        static::$user->clearUserData();
    }

    public function testReturnsFullName()
    {
//        $user = new User;

        static::$user->first_name = "Teresa";
        static::$user->surname    = "Green";
        static::$user->email      = "name.surname@company.com";

        $this->assertEquals('Teresa Green', static::$user->getFullName());
    }

    public function testFullNameIsEmptyByDefault()
    {
//        $user = new User;

        $this->assertEquals('', static::$user->getFullName());
    }

    /**
     * @test
     */
    public function user_has_first_name()
    {
//        $user = new User;

        static::$user->first_name = "Teresa";

        $this->assertEquals('Teresa', static::$user->first_name);
    }

    public function testNotificationIsSent()
    {
//        $user = new User;

//        $user->email = 'user@company.com';
        static::$user->email      = 'john.doe@company.com';

        // Para no enviar mensajes cada vez que hacemos un test, creamos un Mock de la clase Mailer:
        $mockMailer = $this->createMock(Mailer::class);

        // Y le indicamos que devuelve el valor true
        $mockMailer
            ->expects($this->once())
            ->method('sendMessage')
//            ->with($this->equalTo('john.doe@company.com'), $this->equalTo("Hello"))
            ->with('john.doe@company.com', "Hello")
            ->willReturn(true);

        static::$user->setMailer($mockMailer);

        $this->assertTrue(static::$user->notify("Hello"));
    }

    /**
     * @throws Exception
     */
    public function testCannotNotifyUserWithNoEmail()
    {
//        $mockMailer = $this->createMock(Mailer::class);
//        $mockMailer
//            ->method('sendMessage')
//            ->will($this->throwException(new Exception));

        $mockMailer = $this->getMockBuilder(Mailer::class)
            ->setMethods(null) // Usar código de los métodos originales, no vaciar para el Mock
//            ->setMethods(['sendMessage']) // Sólo vaciar el método sendMessage
            ->getMock();

        static::$user->setMailer($mockMailer);

        $this->expectException(Exception::class);
        static::$user->notify("Hello");
    }
}