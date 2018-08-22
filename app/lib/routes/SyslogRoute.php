<?php

namespace PFW\Lib\Routes;

use PFW\Lib\LoggerRoute;
use Psr\Log\LogLevel;

/**
 * Class SyslogRoute
 * @package PFW\Lib\Routes
 */
class SyslogRoute extends LoggerRoute
{
    /**
     * @var string
     */
    public $template = "{message} {context}";

    /**
     * @param $level
     * @param $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
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
