<?php

/**
 * Queue
 *
 * A first-in, first-out data structure
 */
class Queue
{

    /** @var int */
    public const MAX_ITEMS = 5;

    /**
     * Queue items
     * @var array
     */
    protected $items = [];

    /**
     * Add an item to the end of the queue
     *
     * @param mixed $item The item
     *
     * @throws QueueException
     */
    public function push($item)
    {
        if($this->getCount() === self::MAX_ITEMS) {
            throw new QueueException(QueueException::FULL_QUEUE_MESSAGE, QueueException::FULL_QUEUE_CODE);
        }
        $this->items[] = $item;
    }

    /**
     * Take an item off the head of the queue
     *
     * @return mixed The item
     */
    public function pop()
    {
//        return array_pop($this->items);

        // Remove de item from de start of the array:
        return array_shift($this->items);
    }

    /**
     * Get the total number of items in the queue
     *
     * @return integer The number of items
     */
    public function getCount(): int
    {
        return count($this->items);
    }

    public function clear()
    {
        $this->items = [];
    }
}
