<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/19/19 3:18 PM
 */

/**
 * Signal.php
 * Created by @anonymoussc on 6/3/2017 11:11 PM.
 */

namespace App\Components\Signal\Shared;

use Illuminate\Support\Facades\Config;

/**
 * Trait Signal
 * @package App\Components\Signal\Shared
 */
trait Signal
{
    /**
     * @param        $type
     * @param string $message
     * @param array  $param
     */
    protected function fireLog($type, $message = '', array $param = []): void
    {
        switch ($type) {
            case 'emergency':
                $this->logEmergency($message, $param);
                break;
            case 'alert':
                $this->logAlert($message, $param);
                break;
            case 'critical':
                $this->logCritical($message, $param);
                break;
            case 'error':
                $this->logError($message, $param);
                break;
            case 'warning':
                $this->logWarning($message, $param);
                break;
            case 'notice':
                $this->logNotice($message, $param);
                break;
            case 'info':
                $this->logInfo($message, $param);
                break;
            case 'debug':
                $this->logDebug($message, $param);
                break;
            default:
                $this->logInfo($message, $param);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logEmergency(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.emergency')) {
            event('signal.emergency', [$message, $param]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logAlert(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.alert')) {
            event('signal.alert', [$message, $param]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logCritical(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.critical')) {
            event('signal.critical', [$message, $param]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logError(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.error')) {
            event('signal.error', [$message, $param]); // ['error' => $error] $error instanceof \Exception
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logWarning(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.warning')) {
            event('signal.warning', [$message, $param]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logNotice(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.notice')) {
            event('signal.notice', [$message, $param]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logInfo(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.info')) {
            event('signal.info', [$message, $param]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logDebug(string $message = null, array $param = []): void
    {
        if (Config::get('signal.log.activity') && Config::get('signal.log.debug')) {
            event('signal.debug', [$message, $param]);
        }
    }
}