<?php

namespace AlDente\Lib;

use DateTime;
use Psr\Log\AbstractLogger;

/**
 * Class LoggerRoute
 * @package AlDente\Lib
 */
abstract class LoggerRoute extends AbstractLogger
{
    /**
     * @var bool
     */
    public $isEnable = true;
    /**
     * @var string
     */
    private $dateFormat = DateTime::RFC2822;

    /**
     * LoggerRoute constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * Get date and formats it
     * @throws \Exception
     * @return string
     */
    public function getDate(): string
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * Converts an array with context of error to a string
     * @param array $context
     * @return null|string
     */
    public function contextStringify(array $context = []): ?string
    {
        return !empty($context) ? json_encode($context) : null;
    }
}
