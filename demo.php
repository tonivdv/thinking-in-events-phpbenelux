<?php

use Ramsey\Uuid\Uuid;
use ThinkingInEvents\Card;

require_once __DIR__ . '/vendor/autoload.php';

$number = Uuid::uuid4();
$card = Card::create($number, 3);

$card->activate();

var_dump($card);