<?php declare(strict_types=1);

namespace ApiClients\Tests\Foundation\Resource;

use ApiClients\Tools\CommandBus\CommandBus;
use ApiClients\Tools\TestUtilities\TestCase as BaseTestCase;
use League\Tactician\Handler\CommandHandlerMiddleware;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;

class TestCase extends BaseTestCase
{
    protected function getJson(): array
    {
        return [
            'id' => 1,
            'slug' => 'Wyrihaximus/php-travis-client',
            'sub' => [
                'id' => 1,
                'slug' => 'Wyrihaximus/php-travis-client',
            ],
            'subs' => [
                [
                    'id' => 1,
                    'slug' => 'Wyrihaximus/php-travis-client',
                ],
                [
                    'id' => 2,
                    'slug' => 'Wyrihaximus/php-travis-client',
                ],
                [
                    'id' => 3,
                    'slug' => 'Wyrihaximus/php-travis-client',
                ],
            ],
        ];
    }

    protected function getLoop(): LoopInterface
    {
        return Factory::create();
    }

    protected function getCommandBus(LoopInterface $loop): CommandBus
    {
        return new CommandBus(
            $loop,
            $this->prophesize(CommandHandlerMiddleware::class)->reveal()
        );
    }
}
