<?php


use PHPUnit\Framework\TestCase;

class WeatherMonitorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

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
            ->expects($this->exactly(4)) // Primera aserción
            ->method('getTemperature')
            ->will($this->returnValueMap($valueMap));

        $weatherMonitor = new WeatherMonitor($temperatureService);

        // Segunda aserción
        $this->assertEquals(23, $weatherMonitor->getAverageTemperature('12:00', '14:00'));
        $this->assertEquals(34, $weatherMonitor->getAverageTemperature('10:00', '16:00'));
    }

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

        $temperatureService
            ->shouldReceive('getTemperature')
            ->once()
            ->with('10:00')
            ->andReturn(19);

        $temperatureService
            ->shouldReceive('getTemperature')
            ->once()
            ->with('16:00')
            ->andReturn(49);

        $weatherMonitor = new WeatherMonitor($temperatureService);
        $this->assertEquals(23, $weatherMonitor->getAverageTemperature('12:00', '14:00'));
        $this->assertEquals(34, $weatherMonitor->getAverageTemperature('10:00', '16:00'));
    }
}
