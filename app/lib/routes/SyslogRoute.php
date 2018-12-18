<?php

namespace AlDente\Lib\Routes;

use AlDente\Lib\LoggerRoute;
use Psr\Log\LogLevel;

/**
 * Class SyslogRoute
 * @package AlDente\Lib\Routes
 */
class SyslogRoute extends LoggerRoute
{
    /**
     * @var string
     */
    public $template = '{message} {context}';

    /**
     * Add log in to system logs
     * @param $level
     * @param $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = []): void
    {
        $level = $this->resolveLevel($level);
        if ($level === null) {
            return;
        }

        syslog($level, trim(strtr($this->template, [
            '{message}' => $message,
            '{context}' => $this->contextStringify($context),
        ])));
    }

    /**
     * Resolve level
     * @param $level
     * @return mixed|null
     */
    private function resolveLevel($level)
    {
        $map = [
            LogLevel::EMERGENCY => LOG_EMERG,
            LogLevel::ALERT => LOG_ALERT,
            LogLevel::CRITICAL => LOG_CRIT,
            LogLevel::ERROR => LOG_ERR,
            LogLevel::WARNING => LOG_WARNING,
            LogLevel::NOTICE => LOG_NOTICE,
            LogLevel::INFO => LOG_INFO,
            LogLevel::DEBUG => LOG_DEBUG,
        ];
        return $map[$level] ?? null;
    }
}
