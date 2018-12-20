<?php

namespace AlDente\Lib\Routes;

use AlDente\Lib\LoggerRoute;

/**
 * Class FileRoute
 * @package AlDente\Lib\Routes
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
    public $template = '{date} {level} {message} {context}';

    /**
     * FileRoute constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!file_exists($this->filePath)) {
            $resource = fopen(PROJECT_DIR . $this->filePath, 'b');
            fclose($resource);
        }
    }

    /**
     * Add log in to log file at app/logs/default.log
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @throws \Exception
     * @return void
     */
    public function log($level, $message, array $context = []): void
    {
        file_put_contents(PROJECT_DIR . $this->filePath, trim(strtr($this->template, [
                '{date}' => $this->getDate(),
                '{level}' => $level,
                '{message}' => $message,
                '{context}' => $this->contextStringify($context),
            ])) . PHP_EOL, FILE_APPEND);
    }
}
