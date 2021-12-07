<?php

class QueueException extends Exception
{
    public const FULL_QUEUE_CODE    = 500;
    public const FULL_QUEUE_MESSAGE = 'Queue is full';
}