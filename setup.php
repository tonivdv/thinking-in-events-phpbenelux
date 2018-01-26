<?php

require_once __DIR__ . '/vendor/autoload.php';

// THIS FILE IS JUST FOR WORKSHOP PURPOSES, IN PRODUCTION SYSTEM USE MIGRATIONS, DI CONTAINER, ETC.

$config = new \Doctrine\DBAL\Configuration();
$connectionParams = [
    'dbname' => '',
    'user' => '',
    'password' => '',
    'host' => '',
    'port' => '',
    'driver' => 'pdo_mysql',
];

$connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

try {
    $file = __DIR__ . '/vendor/prooph/pdo-event-store/scripts/mysql/01_event_streams_table.sql';
    $stmt = $connection->prepare(file_get_contents($file));
    $stmt->execute();
} catch (\Exception $e) {
}

try {
    $file = __DIR__ . '/vendor/prooph/pdo-event-store/scripts/mysql/02_projections_table.sql';
    $stmt = $connection->prepare(file_get_contents($file));
    $stmt->execute();
} catch (\Exception $e) {
}

$eventBus = new \Prooph\ServiceBus\EventBus();
$eventRouter = new \Prooph\ServiceBus\Plugin\Router\EventRouter();
$eventPublisher = new \Prooph\EventStoreBusBridge\EventPublisher($eventBus);

$eventRouter->attachToMessageBus($eventBus);

$eventStore = new \Prooph\EventStore\Pdo\MySqlEventStore(
    new \Prooph\Common\Messaging\FQCNMessageFactory(),
    $connection->getWrappedConnection(),
    new \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSingleStreamStrategy()
);
$eventStore = new \Prooph\EventStore\ActionEventEmitterEventStore(
    $eventStore,
    new \Prooph\Common\Event\ProophActionEventEmitter()
);

$eventPublisher->attachToEventStore($eventStore);

$streamName = new \Prooph\EventStore\StreamName('event_stream');
$singleStream = new \Prooph\EventStore\Stream($streamName, new ArrayIterator());

if (!$eventStore->hasStream($streamName)) {
    $eventStore->create($singleStream);
}