<?php

namespace CherryPick\Bundle\JsEntitiesBundle\Websocket;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package CherryPick\Bundle\JsEntitiesBundle\Command
 * @author moellers
 */
class WebsocketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cherrypick:websocket')
            ->setDescription('Start a websocket server')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
            new HttpServer(new WsServer($this->getContainer()->get('cherrypick.websocket.rest'))),
            843
        );

        $server->run();
    }
}
