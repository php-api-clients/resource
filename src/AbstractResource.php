<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Tools\CommandBus\CommandBusInterface;
use function Clue\React\Block\await;
use React\EventLoop\LoopInterface;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;

abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    public function __construct(LoopInterface $loop, CommandBusInterface $commandBus)
    {
        $this->loop = $loop;
        $this->commandBus = $commandBus;
    }

    /**
     * @param $command
     * @return CancellablePromiseInterface
     */
    protected function handleCommand($command): CancellablePromiseInterface
    {
        return $this->commandBus->handle($command);
    }

    protected function wait(PromiseInterface $promise)
    {
        return await($promise, $this->loop);
    }
}
