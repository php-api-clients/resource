<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use League\Tactician\CommandBus;

interface ResourceInterface
{
    public function __construct(CommandBus $commandBus);
}
