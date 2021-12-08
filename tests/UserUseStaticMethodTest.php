<?php


use PHPUnit\Framework\TestCase;

class UserUseStaticMethodTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testNotifyReturnsTrue()
    {
        $user = new UserUseStaticMethod('user@domain.com');

        $mailerMock = Mockery::mock('alias:Mailer');
        $mailerMock->shouldReceive('send')
            ->once()
            ->with($user->email, 'Hello!')
            ->andReturn(true);
        $this->assertTrue($user->notify('Hello!'));
    }

//    public function testNotifyReturnsTrue()
//    {
//        $user = new UserUseStaticMethod('user@domain.com');
////        $mailer = new Mailer();
////        $mailer = $this->createMock(Mailer::class);
////        $user->setMailer($mailer);
////        $user->setMailerCallable([Mailer::class, 'send']);
//        $user->setMailerCallable(function() {
//            echo "Mocked";
//            return true;
//        });
//        $this->assertTrue($user->notify('Hello!'));
//    }
}
