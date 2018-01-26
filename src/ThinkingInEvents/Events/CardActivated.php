<?php

namespace ThinkingInEvents\Events;

use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\UuidInterface;

class CardActivated extends AggregateChanged
{
    public static function create(UuidInterface $number)
    {
        return static::occur(
            (string)$number
        );
    }

    public function getNumber(): UuidInterface
    {
        return Uuid::fromString($this->aggregateId());
    }
}