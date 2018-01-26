<?php

namespace ThinkingInEvents;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\UuidInterface;
use ThinkingInEvents\Events\CardActivated;
use ThinkingInEvents\Events\CardPurchased;

class Card extends AggregateRoot
{
    /**
     * @var UuidInterface
     */
    private $number;

    /**
     * @var \DateTime
     */
    private $registeredDate;

    /**
     * @var
     */
    private $numberOfUse;

    /**
     * @var
     */
    private $numberOfAllowedVisits;


    public static function create(UuidInterface $number, int $numberOfAllowedVisits)
    {
        $card = new self();

        $card->recordThat(
            CardPurchased::create($number, $numberOfAllowedVisits)
        );

        return $card;
    }

    public function activate()
    {
        // What about multiple activations?

        $this->recordThat(
            CardActivated::create($this->number)
        );
    }

    public function deactive()
    {
        // Any extra conditions here?

    }

    public function registerVisit()
    {
        // GUARD HERE!
        // Any extra conditions here?

    }

    public function block()
    {
        // Any extra conditions here?

    }

    public function unblock()
    {
        // Any extra conditions here?
    }

    protected function aggregateId(): string
    {
        return $this->number->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case CardPurchased::class:
                $this->number = $event->getNumber();
                $this->numberOfAllowedVisits = $event->getNumberOfAllowedVisits();

                break;
        }
    }

    /**
     * Better way to void huge amount of code in apply(...) method...
     * Just split event processing into separated methods.
     */
    protected function whenCardPurchased(CardPurchased $event)
    {

    }
}













//