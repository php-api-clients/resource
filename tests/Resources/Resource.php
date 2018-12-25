<?php
declare(strict_types=1);

namespace ApiClients\Tests\Foundation\Resource\Resources;

use ApiClients\Foundation\Annotations\Collection;
use ApiClients\Foundation\Annotations\Nested;
use ApiClients\Foundation\Annotations\Rename;
use ApiClients\Foundation\Resource\AbstractResource;
use ApiClients\Foundation\Resource\ResourceInterface;
use React\Promise\PromiseInterface;

/**
 * @Nested(sub="SubResource")
 * @Collection(subs="SubResource")
 * @Rename(slug="slog")
 */
class Resource extends AbstractResource implements ResourceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var SubResource
     */
    protected $sub;

    /**
     * @var array
     */
    protected $subs;

    public function id(): int
    {
        return $this->id;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function sub(): SubResource
    {
        return $this->sub;
    }

    public function subs(): array
    {
        return $this->subs;
    }

    public function refresh(): void
    {
    }

    public function consumePromise(PromiseInterface $promise)
    {
        return $this->wait($promise);
    }
}
