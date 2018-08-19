<?php

namespace PFW\Lib;

use DateTime;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

abstract class LoggerRoute extends AbstractLogger implements LoggerInterface
{
    public $isEnable = true;
    private $dateFormat = DateTime::RFC2822;

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * @param array $context
     * @return null|string
     */
    public function contextStringify(array $context = [])
    {
        return !empty($context) ? json_encode($context) : null;
    }
}
