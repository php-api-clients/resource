<?php declare(strict_types=1);

namespace ApiClients\Foundation;

use ApiClients\Foundation\Resource\ResourceInterface;
use ReflectionClass;
use ReflectionProperty;

/**
 * @param ResourceInterface $resource
 * @param int               $indentLevel
 * @param bool              $resourceIndent
 */
function resource_pretty_print(ResourceInterface $resource, int $indentLevel = 0, bool $resourceIndent = false): void
{
    $indent = \str_repeat("\t", $indentLevel);
    $propertyIndent = \str_repeat("\t", $indentLevel + 1);
    $arrayIndent = \str_repeat("\t", $indentLevel + 2);

    if ($resourceIndent) {
        echo $indent;
    }
    echo \get_class($resource), PHP_EOL;

    foreach (get_properties($resource) as $property) {
        echo $propertyIndent, $property->getName(), ': ';

        $propertyValue = get_property($resource, $property->getName())->getValue($resource);

        if ($propertyValue instanceof ResourceInterface) {
            resource_pretty_print($propertyValue, $indentLevel + 1);
            continue;
        }

        if (\is_array($propertyValue)) {
            echo '[', PHP_EOL;
            foreach ($propertyValue as $arrayKey => $arrayValue) {
                if ($arrayValue instanceof ResourceInterface) {
                    resource_pretty_print($arrayValue, $indentLevel + 2, true);
                    continue;
                }

                echo $arrayIndent, $arrayKey, ': ';

                if (\is_array($arrayValue)) {
                    array_pretty_print($arrayValue, $arrayIndent + 2);
                    continue;
                }

                echo $arrayValue, PHP_EOL;
            }
            echo $propertyIndent, ']', PHP_EOL;
            continue;
        }

        echo $propertyValue, PHP_EOL;
    }
}

/**
 * @param array $array
 * @param int   $indentLevel
 */
function array_pretty_print(array $array, int $indentLevel = 0): void
{
    $indent = \str_repeat("\t", $indentLevel);
    $propertyIndent = \str_repeat("\t", $indentLevel + 1);
    echo '[', PHP_EOL;
    foreach ($array as $key => $value) {
        echo $propertyIndent, $key, ': ';
        if (\is_array($value)) {
            array_pretty_print($value, $indentLevel + 1);
            continue;
        }

        echo $value, PHP_EOL;
    }
    echo $indent, ']', PHP_EOL;
}

/**
 * @param  ResourceInterface $resource
 * @return array
 */
function get_properties(ResourceInterface $resource): array
{
    $class = new ReflectionClass($resource);

    return $class->getProperties();
}

/**
 * @param  ResourceInterface  $resource
 * @param  string             $property
 * @return ReflectionProperty
 */
function get_property(ResourceInterface $resource, string $property)
{
    $class = new ReflectionClass($resource);
    $prop = $class->getProperty($property);
    $prop->setAccessible(true);

    return $prop;
}
