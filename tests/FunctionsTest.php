<?php declare(strict_types=1);

namespace ApiClients\Tests\Foundation\Resource;

use ApiClients\Tests\Foundation\Resource\Resources\Async\SubResource;
use ApiClients\Tests\Foundation\Resource\Resources\Sync\Resource;
use function ApiClients\Foundation\array_pretty_print;
use function ApiClients\Foundation\get_properties;
use function ApiClients\Foundation\get_property;
use function ApiClients\Foundation\resource_pretty_print;

class FunctionsTest extends TestCase
{
    public function testGetProperties()
    {
        $properties = [];

        $loop = $this->getLoop();
        foreach (get_properties(new Resource($loop, $this->getCommandBus($loop))) as $property) {
            $properties[] = $property->getName();
        }

        $this->assertSame([
            'id',
            'slug',
            'sub',
            'subs',
        ], $properties);
    }

    public function testGetProperty()
    {
        $loop = $this->getLoop();
        $resource = new Resource($loop, $this->getCommandBus($loop));
        get_property($resource, 'id')->setValue($resource, $this->getJson()['id']);

        $this->assertSame(
            $this->getJson()['id'],
            get_property($resource, 'id')->getValue($resource)
        );
    }

    public function testResourcePrettyPrint()
    {
        $loop = $this->getLoop();
        $resource = new Resource($loop, $this->getCommandBus($loop));
        get_property($resource, 'id')->setValue($resource, $this->getJson()['id']);
        get_property($resource, 'slug')->setValue($resource, $this->getJson()['slug']);

        $sub = new SubResource($loop, $this->getCommandBus($loop));
        get_property($sub, 'id')->setValue($sub, $this->getJson()['id']);
        get_property($sub, 'slug')->setValue($sub, $this->getJson()['slug']);
        get_property($resource, 'sub')->setValue($resource, $sub);

        $subs = [];
        foreach ($this->getJson()['subs'] as $index => $row) {
            $subZero = new SubResource($loop, $this->getCommandBus($loop));
            get_property($subZero, 'id')->setValue($subZero, $row['id']);
            get_property($subZero, 'slug')->setValue($subZero, $row['slug']);
            $subs[] = $subZero;
        }
        get_property($resource, 'subs')->setValue($resource, $subs);

        $expected = "ApiClients\Tests\Foundation\Resource\Resources\Sync\Resource
	id: 1
	slug: Wyrihaximus/php-travis-client
	sub: ApiClients\Tests\Foundation\Resource\Resources\Async\SubResource
		id: 1
		slug: Wyrihaximus/php-travis-client
	subs: [
		ApiClients\Tests\Foundation\Resource\Resources\Async\SubResource
			id: 1
			slug: Wyrihaximus/php-travis-client
		ApiClients\Tests\Foundation\Resource\Resources\Async\SubResource
			id: 2
			slug: Wyrihaximus/php-travis-client
		ApiClients\Tests\Foundation\Resource\Resources\Async\SubResource
			id: 3
			slug: Wyrihaximus/php-travis-client
	]
";
        ob_start();
        resource_pretty_print($resource);
        $actual = ob_get_clean();

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $expected = str_replace(
                [
                    "\r",
                    "\n",
                ],
                '',
                $expected
            );
            $actual = str_replace(
                [
                    "\r",
                    "\n",
                ],
                '',
                $actual
            );
        }

        $this->assertSame($expected, $actual);
    }

    public function testArrayPrettyPrint()
    {
        $array = [
            'foo' => 'bar',
            'bar' => [
                [
                    'bar',
                ],
            ],
        ];

        ob_start();
        array_pretty_print($array);
        $actual = ob_get_clean();

        $expected = "[
	foo: bar
	bar: [
		0: [
			0: bar
		]
	]
]
";

        $this->assertSame($expected, $actual);
    }
}
