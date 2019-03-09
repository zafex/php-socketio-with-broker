## BROKER MESSAGE (RabbitMQ)
run rabbit under docker
```bash
docker run --rm -p 5672:5672 rabbitmq:3
# rabbitmq listen for port 5672
```

## SENDER (client)
Using php connected to rabbitmq
```bash
composer install
```

## SERVER (websocket)
with socket.io connected to rabbitmq as relay
```bash
npm install
npm start
```

open client.html on your browser;

and under command line:
```bash
sender.php Hello World!
```