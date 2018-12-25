<?php declare(strict_types=1);

namespace ApiClients\Tests\Foundation\Resource;

use ApiClients\Foundation\Resource\DummyResource;
use ApiClients\Tests\Foundation\Resource\Resources\Sync\Resource;
use ApiClients\Tools\CommandBus\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use Prophecy\Argument;
use React\Promise\FulfilledPromise;

/**
 * @internal
 */
class ResourceTest extends TestCase
{
    public function testResourceWait(): void
    {
        $loop = $this->getLoop();
        $resource = new Resource($loop, $this->getCommandBus($loop));
        $this->assertSame('foo.bar', $resource->consumePromise(new FulfilledPromise('foo.bar')));
    }

    public function testHandleCommand(): void
    {
        $command = new \stdClass();
        $loop = $this->getLoop();
        $middleware = $this->prophesize(CommandHandlerMiddleware::class);
        $middleware->execute($command, Argument::type('callable'))->shouldBeCalled()->willReturn(function (): void {
        });
        $commandBus = new CommandBus(
            $loop,
            $middleware->reveal()
        );
        $resource = new DummyResource($loop, $commandBus);
        $resource->wrapper('handleCommand', $command);
        $loop->run();
    }
}
