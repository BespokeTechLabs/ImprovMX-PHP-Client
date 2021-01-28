<?php

namespace Bespoke\ImprovMX\Entities;

use DateTime;
use DateTimeZone;
use Exception;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Class AbstractEntity
 */
abstract class AbstractEntity
{
    /**
     * Construct an entity from an array of properties.
     * @param object|array|null $parameters
     *
     * @return void
     */
    public function __construct($parameters = null)
    {
        if (null === $parameters) {
            return;
        }

        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        $this->build($parameters);
    }

    /**
     * Populate the properties within the instance from an array of parameters.
     * @param array $parameters
     *
     * @return void
     */
    public function build(array $parameters): void
    {
        foreach ($parameters as $property => $value) {
            $property = static::convertToCamelCase($property);

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Convert the instance variables to an array.
     * @return array
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        $settings = [];
        $called = static::class;

        $reflection = new ReflectionClass($called);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $prop = $property->getName();
            if (isset($this->$prop) && $property->class == $called) {
                $settings[self::convertToSnakeCase($prop)] = $this->$prop;
            }
        }

        return $settings;
    }

    /**
     * Convert a date to ISO 8601 format.
     * @param string $date DateTime string
     *
     * @return string
     * @throws Exception
     * @noinspection PhpUnused
     */
    protected static function convertToIso8601(string $date): string
    {
        $date = new DateTime($date);
        $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
        return $date->format(DateTime::ISO8601);
    }

    /**
     * Convert a string to camel case.
     * @param string $str
     *
     * @return string
     */
    protected static function convertToCamelCase(string $str): string
    {
        $callback = function ($match): string {
            return strtoupper($match[2]);
        };

        $replaced = preg_replace_callback('/(^|_)([a-z])/', $callback, $str);

        if (null === $replaced) {
            throw new RuntimeException(sprintf('preg_replace_callback error: %s', preg_last_error_msg()));
        }

        return lcfirst($replaced);
    }

    /**
     * Convert a string to snake case.
     * @param string $str
     *
     * @return string
     */
    protected static function convertToSnakeCase(string $str): string
    {
        $replaced = preg_split('/(?=[A-Z])/', $str);

        if (false === $replaced) {
            throw new RuntimeException(sprintf('preg_split error: %s', preg_last_error_msg()));
        }

        return strtolower(implode('_', $replaced));
    }
}
