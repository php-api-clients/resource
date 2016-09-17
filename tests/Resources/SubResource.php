<?php
declare(strict_types=1);

namespace ApiClients\Tests\Foundation\Resource\Resources;

use ApiClients\Foundation\Resource\AbstractResource;
use ApiClients\Foundation\Resource\ResourceInterface;

class SubResource extends AbstractResource implements ResourceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    public function id() : int
    {
        return $this->id;
    }

    public function slug() : string
    {
        return $this->slug;
    }

    public function refresh()
    {
    }

    public function setTransport(Client $client)
    {
    }
}
