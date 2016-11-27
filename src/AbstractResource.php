<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Tools\CommandBus\CommandBus;
use React\Promise\CancellablePromiseInterface;

abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $command
     * @return CancellablePromiseInterface
     */
    public function handleCommand($command): CancellablePromiseInterface
    {
        return $this->commandBus->handle($command);
    }
}
