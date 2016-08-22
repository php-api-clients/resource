<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Foundation\Hydrator\Annotations\Collection;
use ApiClients\Foundation\Hydrator\Annotations\Nested;

/**
 * @Nested(foo="Acme\Bar", bar="Acme\Foo")
 * @Collection(foo="Acme\Bar", bar="Acme\Foo")
 */
class DummyResource extends AbstractResource implements ResourceInterface
{
    public function wrapper($method, ...$args)
    {
        return $this->$method(...$args);
    }
}
