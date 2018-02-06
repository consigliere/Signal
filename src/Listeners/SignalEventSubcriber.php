<?php
/**
 * SignalEventSubcriber.php
 * Created by @anonymoussc on 6/3/2017 11:03 PM.
 */

namespace App\Components\Signal\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Components\Signal\Models\Signal;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Components\Signal\Emails\SignalMailer;
use Onsigbaar\Foundation\Base\Traits\ErrorLog;

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

    public function __construct()
    {
        $this->agent = new Agent;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('event.emergency', 'App\Components\Signal\Listeners\SignalEventSubcriber@onEmergency', 10);
        $events->listen('event.alert', 'App\Components\Signal\Listeners\SignalEventSubcriber@onAlert', 10);
        $events->listen('event.critical', 'App\Components\Signal\Listeners\SignalEventSubcriber@onCritical', 10);
        $events->listen('event.error', 'App\Components\Signal\Listeners\SignalEventSubcriber@onError', 10);
        $events->listen('event.warning', 'App\Components\Signal\Listeners\SignalEventSubcriber@onWarning', 10);
        $events->listen('event.notice', 'App\Components\Signal\Listeners\SignalEventSubcriber@onNotice', 10);
        $events->listen('event.info', 'App\Components\Signal\Listeners\SignalEventSubcriber@onInfo', 10);
        $events->listen('event.debug', 'App\Components\Signal\Listeners\SignalEventSubcriber@onDebug', 10);
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onEmergency(array $log, $level = 'emergency', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onAlert(array $log, $level = 'alert', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onCritical(array $log, $level = 'critical', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onError(array $log, $level = 'error', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                if (isset($log['error'])) {
                    $logData['errorLog']         = true;
                    $logData['getMessage']       = $log['error']->getMessage();
                    $logData['getCode']          = $log['error']->getCode();
                    $logData['getFile']          = $log['error']->getFile();
                    $logData['getLine']          = $log['error']->getLine();
                    $logData['getTraceAsString'] = $log['error']->getTraceAsString();
                }

                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onWarning(array $log, $level = 'warning', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onNotice(array $log, $level = 'notice', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onInfo(array $log, $level = 'info', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onDebug(array $log, $level = 'debug', array $param = [])
    {
        try {
            $logData = self::getLogData($log, $level);

            if (Signal::insert($logData)) {
                self::sendMail($logData);
            }
        }
        catch (\Exception $e) {
            self::errorLog($e);
        }

        return true;
    }

    /**
     * Convenience function for sending mail
     *
     * @param       $email
     * @param       $subject
     * @param       $view
     * @param array $data
     */
    private function sendTo($email, $subject, $view, $data = [])
    {
        $sender = $this->gatherSenderAddress();
        Mail::queue($view, $data, function($message) use ($email, $subject, $sender) {
            $message->to($email)
                ->from($sender['address'], $sender['name'])
                ->subject($subject);
        });
    }

    /**
     * If the application does not have a valid "from" address configured, we should stub in
     * a temporary alternative so we have something to pass to the Mailer
     *
     * @return array|mixed
     */
    private function gatherSenderAddress()
    {
        $sender = config('mail.from', []);
        if (!array_key_exists('address', $sender) || is_null($sender['address'])) {
            return ['address' => 'noreply@example.com', 'name' => ''];
        }
        if (is_null($sender['name'])) {
            $sender['name'] = '';
        }

        return $sender;
    }

    /**
     * @param $language
     *
     * @return string
     */
    private function toString($language)
    {
        if (is_array($language)) {
            $agent = json_encode($language);
        } else {
            $agent = $language;
        }

        return $agent;
    }

    private function sendMail($data)
    {
        if (config('signal.email.sent')) {
            try {
                unset($data['created_at']);
                $data['logMessage'] = $data['message'];
                unset($data['message']);

                Mail::to(config('signal.email.sentTo'))->send(new SignalMailer($data));
            }
            catch (\Exception $e) {
                self::errorLog($e);
            }
        }
    }

    private function getLogData(array $log = [], $level = '', array $param = [])
    {
        $request       = (isset($log['request'])) ? $log['request'] : app('request');
        $userId        = (null !== Auth::id()) ? Auth::id() : 0;
        $agentLanguage = $this->toString($this->agent->languages());

        $logData = [
            'level'                   => $level,
            'message'                 => $log['message'],
            'request_full_url'        => $request->fullUrl() ? $request->fullUrl() : 'undefined',
            'request_url'             => $request->url() ? $request->url() : 'undefined',
            'request_uri'             => $request->path() ? $request->path() : 'undefined',
            'request_method'          => app('request')->header('x-http-method-override') ? app('request')->header('x-http-method-override') : $request->method(),
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

        return $logData;
    }
}
