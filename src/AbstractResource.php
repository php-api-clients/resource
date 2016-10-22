<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Tools\CommandBus\CommandBus;

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
     * @return CommandBus
     */
    protected function getCommandBus()
    {
        return $this->commandBus;
    }
}
