<?php

namespace ThinkingInEvents\Events;

use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CardPurchased extends AggregateChanged
{
    public static function create(UuidInterface $number, int $numberOfAllowedVisits)
    {
        return static::occur(
            (string)$number,
            [
                'number_of_allowed_visits' => $numberOfAllowedVisits,
            ]
        );
    }

    public function getNumber(): UuidInterface
    {
        return Uuid::fromString($this->aggregateId());
    }

    public function getNumberOfAllowedVisits(): int
    {
        return $this->payload['number_of_allowed_visits'];
    }
}