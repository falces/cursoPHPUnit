<?php


use PHPUnit\Framework\TestCase;

class NewOrderTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testOrderIsProcessedUsingAMock()
    {
        $order = new NewOrder(3, 1.99);

        $this->assertEquals(5.97, $order->amount);

        $gatewayPaymentMock = Mockery::mock('PaymentGateway');
        $gatewayPaymentMock
            ->shouldReceive('charge')
            ->once()
            ->with(5.97)
            ->andReturn(true);

        $this->assertTrue($order->process($gatewayPaymentMock));
    }

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
}
