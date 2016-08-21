<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Foundation\Hydrator\HydrateTrait;

abstract class AbstractResource implements ResourceInterface
{
    use HydrateTrait;

    public function setExtraProperties(array $properties)
    {

    }
}
