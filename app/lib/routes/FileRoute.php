<?php

namespace PFW\Lib\Routes;

use PFW\Lib\LoggerRoute;

/**
 * Class FileRoute
 * @package PFW\Lib\Routes
 */
class FileRoute extends LoggerRoute
{
    /**
     * @var
     */
    public $filePath;
    /**
     * @var string
     */
    public $template = "{date} {level} {message} {context}";

    /**
     * FileRoute constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!file_exists($this->filePath)) {
            $resource = fopen(PROJECT_DIR . $this->filePath, 'w');
            fclose($resource);
        }
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
    {
        file_put_contents(PROJECT_DIR . $this->filePath, trim(strtr($this->template, [
                '{date}' => $this->getDate(),
                '{level}' => $level,
                '{message}' => $message,
                '{context}' => $this->contextStringify($context),
            ])) . PHP_EOL, FILE_APPEND);
    }
}
