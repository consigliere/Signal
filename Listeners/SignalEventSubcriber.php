<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/19/19 3:17 PM
 */

/**
 * SignalEventSubcriber.php
 * Created by @anonymoussc on 6/3/2017 11:03 PM.
 */

namespace App\Components\Signal\Listeners;

use App\Components\Signal\Emails\SignalMailer;
use App\Components\Signal\Entities\Signal;
use App\Components\Signal\Shared\ErrorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Webpatser\Uuid\Uuid;

/**
 * Class SignalEventSubcriber
 * @package App\Components\Signal\Listeners
 */
class SignalEventSubcriber
{
    use ErrorLog;

    /**
     * @var \Jenssegers\Agent\Agent
     */
    private $agent;

    /**
     * SignalEventSubcriber constructor.
     */
    public function __construct()
    {
        $this->agent = new Agent;
    }

    /**
     * @param $events
     */
    public function subscribe($events): void
    {
        $events->listen('signal.emergency', 'App\Components\Signal\Listeners\SignalEventSubcriber@onEmergency', 10);
        $events->listen('signal.alert', 'App\Components\Signal\Listeners\SignalEventSubcriber@onAlert', 10);
        $events->listen('signal.critical', 'App\Components\Signal\Listeners\SignalEventSubcriber@onCritical', 10);
        $events->listen('signal.error', 'App\Components\Signal\Listeners\SignalEventSubcriber@onError', 10);
        $events->listen('signal.warning', 'App\Components\Signal\Listeners\SignalEventSubcriber@onWarning', 10);
        $events->listen('signal.notice', 'App\Components\Signal\Listeners\SignalEventSubcriber@onNotice', 10);
        $events->listen('signal.info', 'App\Components\Signal\Listeners\SignalEventSubcriber@onInfo', 10);
        $events->listen('signal.debug', 'App\Components\Signal\Listeners\SignalEventSubcriber@onDebug', 10);
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onEmergency(string $message = '', array $param = []): bool
    {
        $type = 'emergency';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onAlert(string $message = '', array $param = []): bool
    {
        $type = 'alert';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onCritical(string $message = '', array $param = []): bool
    {
        $type = 'critical';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onError(string $message = '', array $param = []): bool
    {
        $type = 'error';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {

                if (isset($param['error'])) {
                    $logData['errorLog'] = true;
                }

                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onWarning(string $message = '', array $param = []): bool
    {
        $type = 'warning';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onNotice(string $message = '', array $param = []): bool
    {
        $type = 'notice';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onInfo(string $message = '', array $param = []): bool
    {
        $type = 'info';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $param
     *
     * @return bool
     */
    public function onDebug(string $message = '', array $param = []): bool
    {
        $type = 'debug';

        try {
            $logData = $this->getLogData($type, $message, $param);

            if (Signal::insert($logData)) {
                $this->sendMail($logData);
            }
        } catch (\Exception $e) {
            $this->errorLog($e);
        }

        return true;
    }

    /**
     * @param $language
     *
     * @return string
     */
    private function toString($language): string
    {
        return is_array($language) ? json_encode($language) : $language;
    }

    /**
     * @param $data
     */
    private function sendMail($data): void
    {
        if (Config::get('signal.email.sent')) {
            try {
                unset($data['created_at']);
                $data['logMessage'] = $data['message'];
                unset($data['message']);

                Mail::to(Config::get('signal.email.sentTo'))->send(new SignalMailer($data));
            } catch (\Exception $e) {
                $this->errorLog($e);
            }
        }
    }

    /**
     * @param        $type
     * @param string $message
     * @param array  $param
     *
     * @return array
     */
    private function getLogData($type, string $message = '', array $param = []): array
    {
        $request       = $param['request'] ?? App::get('request');
        $userId        = Auth::id() ?? 0;
        $agentLanguage = $this->toString($this->agent->languages());

        $logData = [
            'level'                   => $type,
            'message'                 => $message,
            'request_full_url'        => $request->fullUrl() ?: 'undefined',
            'request_url'             => $request->url() ?: 'undefined',
            'request_uri'             => $request->path() ?: 'undefined',
            'request_method'          => App::get('request')->header('x-http-method-override') ?: $request->method(),
            'devices'                 => $this->agent->device(),
            'os'                      => $this->agent->platform(),
            'os_version'              => $this->agent->version($this->agent->platform()),
            'browser_name'            => $this->agent->browser(),
            'browser_version'         => $this->agent->version($this->agent->browser()),
            'browser_accept_language' => $agentLanguage,
            'robot'                   => $this->agent->robot(),
            'client_ip'               => $request->ip(),
            'user_id'                 => $userId,
            'created_at'              => Carbon::now(),
        ];

        if (isset($param['error'])) {
            $error = $param['error'];
            if ($error instanceof \Exception) {
                $logData['error_uuid']        = $param['uuid'] ?? (string)Uuid::generate(4);
                $logData['error_get_message'] = $error->getMessage() ?: null;
                $logData['error_get_code']    = $error->getCode() ?: null;
                $logData['error_get_file']    = $error->getFile() ?: null;
                $logData['error_get_line']    = $error->getLine() ?: null;
                $logData['error_get_trace']   = $error->getTraceAsString() ?: null;
            }
        }

        return $logData;
    }
}
