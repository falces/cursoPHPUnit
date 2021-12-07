<?php

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testProcess()
    {
//        $paymentGateway = new PaymentGateway;
//        $paymentGateway = $this->createMock('PaymentGateway');

        $paymentGateway = $this->getMockBuilder('PaymentGateway')
            ->setMethods(['charge'])
            ->getMock();

        $paymentGateway
            ->expects($this->once())
            ->method('charge')
            ->with(200)
            ->willReturn(true);

        $order = new Order($paymentGateway);
        $order->amount = 200;
        $this->assertTrue($order->process());
    }

    public function testProcessUsingMockery()
    {
        $paymentGateway = Mockery::mock('PaymentGateway');

        $paymentGateway->shouldReceive('charge')
            ->once()
            ->with(200)
            ->andReturn(true);

        $order = new Order($paymentGateway);
        $order->amount = 200;
        $this->assertTrue($order->process());
    }
}
