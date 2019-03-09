<?php

require_once __DIR__ . '/vendor/autoload.php';

$factory = new Enqueue\AmqpLib\AmqpConnectionFactory([
	'host' => 'localhost',
	'port' => 5672,
	'user' => 'guest',
	'pass' => 'guest',
	'vhost' => '/'
]);

$params = array_slice($argv, 1);

$context = $factory->createContext();

$producer = $context->createProducer();
$message = $context->createMessage(
	json_encode([
		'message' => implode(' ', $params)
	])
);
$message->setContentType('application/json');

$topic = $context->createTopic('amq.topic');
$topic->setType(Interop\Amqp\AmqpTopic::TYPE_TOPIC);
$topic->addFlag(Interop\Amqp\AmqpTopic::FLAG_DURABLE);

$queue = $context->createQueue('send message');

$context->declareTopic($topic);
$context->declareQueue($queue);
$context->bind(new Interop\Amqp\Impl\AmqpBind($topic, $queue));

$producer->send($queue, $message);
