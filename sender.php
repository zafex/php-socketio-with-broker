<?php

require_once __DIR__ . '/vendor/autoload.php';

/**
 * see server.js
 */
class TaskPassenger extends Viloveul\Transport\Passenger
{
    public function handle(): void
    {
        $params = array_slice($_SERVER['argv'], 1);
        $this->setAttribute('message', implode(' ', $params));
    }

    public function point(): string
    {
        // queue name
        return 'notification.queue';
    }

    public function task(): string
    {
        // not used for socketio
        return 'send.message';
    }
}

$bus = new Viloveul\Transport\Bus();
$bus->addConnection('amqp://localhost:5672//');
$bus->process(new TaskPassenger());
$bus->error()->clear();
