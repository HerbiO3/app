<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . './../../vendor/autoload.php';

// Create a new WebSocket server
$server = new Ratchet\WebSocket\WsServer(new WebSocketHandler([]));

// Start the server
$socketServer = new Ratchet\App('localhost', 8080);
$socketServer->route('/your-route', $server);
//$socketServer->run();
