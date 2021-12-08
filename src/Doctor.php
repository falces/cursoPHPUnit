<?php

class Doctor extends AbstractPerson
{
    protected function getTitle(): string
    {
        return 'Dr.';
    }
}