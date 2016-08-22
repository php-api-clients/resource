<?php declare(strict_types=1);

namespace ApiClients\Foundation\Resource;

use ApiClients\Foundation\Hydrator\HydrateTrait;

abstract class AbstractResource implements ResourceInterface
{
    use HydrateTrait;

    public function setExtraProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->setPropertyValue($key, $value);
        }
    }

    private function setPropertyValue(string $key, $value)
    {
        $methodName = $key . 'Setter';
        if (!method_exists($this, $methodName)) {
            return;
        }

        $this->$methodName($value);
    }
}
