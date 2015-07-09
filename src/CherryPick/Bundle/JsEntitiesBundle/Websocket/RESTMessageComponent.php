<?php

namespace CherryPick\Bundle\JsEntitiesBundle\Websocket;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle\Websocket
 * @author moellers
 */
class RESTMessageComponent implements MessageComponentInterface
{

    /**
     * @var \SplObjectStorage
     */
    protected $clients;

    /**
     * @var KernelInterface
     */
    private $kernel;

    public function __construct(KernelInterface $kernel) {
        $this->clients = new \SplObjectStorage;
        $this->kernel = $kernel;
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $message The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $message)
    {
        $json = json_decode($message, true, 2);
        $ticket = $json['ticket'];
        $method = $json['method'];
        $requestContent = $json['request'];

        // Dispatch request.
        $server = [
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => '/data/',
            'SERVER_PORT' => 843,
            'HTTP_HOST' => 'localhost:843',
            'HTTP_ACCEPT' => 'application/json',
        ];
        $request = new Request([], [], [], [], [], $server, $requestContent);
        $response = $this->kernel->handle($request);
        // Send back response.
        $websocketData = json_encode([
            'ticket' => $ticket,
            'status' => $response->getStatusCode(),
            'response' => $response->getContent(),
        ]);
        $from->send($websocketData);
    }
}
