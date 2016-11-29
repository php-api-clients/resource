<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Tools\CommandBus\CommandBus;
use function Clue\React\Block\await;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use React\Promise\CancellablePromiseInterface;

abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(LoopInterface $loop, CommandBus $commandBus)
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
