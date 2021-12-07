<?php

use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    /** @var $queue Queue */
    protected static $queue;

    public Queue $queue2;

    protected function setUp(): void
    {
//        $this->queue = new Queue();
        static::$queue->clear();
    }

    public static function setUpBeforeClass(): void
    {
        static::$queue = new Queue();
    }

    protected function tearDown(): void
    {
//        unset($this->queue);
    }

    public static function tearDownAfterClass(): void
    {
        static::$queue = null;
    }

    public function testNewQueueIsEmpty()
    {
        $this->assertEquals(0, static::$queue->getCount());
    }

    public function testAnItemIsAddedToTheQueue()
    {
        static::$queue->push('green');

        $this->assertEquals(1, static::$queue->getCount());
    }

    public function testAnItemIsRemovedFromTheQueue()
    {
        static::$queue->push('green');
        $item = static::$queue->pop();

        $this->assertEquals(0, static::$queue->getCount());
        $this->assertEquals('green', $item);
    }

    /**
     * @throws QueueException
     */
    public function testAnItemIsRemovedFromTheFrontOfTheQueue()
    {
        static::$queue->push('first');
        static::$queue->push('second');

        $this->assertEquals('first', static::$queue->pop());
    }

    /**
     * @throws QueueException
     */
    public function testMaxNumberOfItemsCanBeAdded()
    {
        for($i = 0; $i < Queue::MAX_ITEMS; $i++) {
            static::$queue->push(('item' . $i));
        }

        $this->assertEquals(static::$queue::MAX_ITEMS, static::$queue->getCount());
    }

    /**
     * @throws QueueException
     */
    public function testExceptionThrownWhenAddingAnItemToAFullQueue()
    {
        for($i = 0; $i < Queue::MAX_ITEMS; $i++) {
            static::$queue->push(('item' . $i));
        }

        $this->expectException(QueueException::class);
        $this->expectExceptionMessage(QueueException::FULL_QUEUE_MESSAGE);
        $this->expectExceptionCode(QueueException::FULL_QUEUE_CODE);
        static::$queue->push('Add this item should fail');
    }
}