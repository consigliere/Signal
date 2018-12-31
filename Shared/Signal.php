<?php
/**
 * Signal.php
 * Created by @anonymoussc on 6/3/2017 11:11 PM.
 */

namespace App\Components\Signal\Shared;

use  Illuminate\Support\Facades\Config;


trait Signal
{
    /**
     * @param        $type
     * @param string $message
     * @param array  $param
     */
    protected function fireLog($type, $message = '', array $param = [])
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
            case 'custom-debug':
                $this->logCustomDebug($message, $param);
                break;
            default:
                $this->logInfo($message, $param);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logEmergency($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.emergency'))) {
            \Event::fire('signal.emergency', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logAlert($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.alert'))) {
            \Event::fire('signal.alert', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logCritical($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.critical'))) {
            \Event::fire('signal.critical', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logError($message = 'Error', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.error'))) {
            \Event::fire('signal.error', [['message' => $message, 'error' => $param['error']]]); // $error instanceof \Exception
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logWarning($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.warning'))) {
            \Event::fire('signal.warning', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logNotice($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.notice'))) {
            \Event::fire('signal.notice', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logInfo($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.info'))) {
            \Event::fire('signal.info', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logDebug($message = 'Success', array $param = [])
    {
        if ((Config::get('signal.log.activity')) && (Config::get('signal.log.debug'))) {
            \Event::fire('signal.debug', [['message' => $message]]);
        }
    }

    /**
     * @param string $message
     * @param array  $param
     */
    private function logCustomDebug($message = 'Success', array $param = [])
    {
        $table     = (isset($param['table'])) ? $param['table'] : 'N/A';
        $condition = (isset($param['condition'])) ? $param['condition'] : 'N/A';
        $construct = (isset($param['construct'])) ? $param['construct'] : '';
        $message   = (isset($param['message'])) ? $param['message'] : $message;

        if (is_array($message)) {
            $this->logInfo('Values of string expected but array given.', $param);
            $message = implode(", ", $message);
        }
        if ((isset($param['status'])) && (!$param['status'])) {
            if ((Config::get('signal.log.activity')) && (Config::get('signal.log.error'))) {
                \Event::fire('signal.error', [['message' => $param['e']->getMessage()]]);
            }
        } else {
            if ((Config::get('signal.log.activity')) && (Config::get('signal.log.debug'))) {
                if (isset($param['construct'])) {
                    $query      = $construct->toSql();
                    $queryCount = $construct->count();

                    \Event::fire('signal.debug', [
                        ['message' => 'Success get data from ' . $table . ' table, count records "' . $queryCount . '", with query : "' . $query . '"'],
                    ]);
                } else {
                    \Event::fire('signal.debug', [['message' => $message]]);
                }
            }
        }
    }
}