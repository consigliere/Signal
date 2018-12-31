<?php
/**
 * SignalEventSubcriber.php
 * Created by @anonymoussc on 6/3/2017 11:03 PM.
 */

namespace App\Components\Signal\Listeners;

use Illuminate\Support\Facades\{Auth, Mail, Config, App};
use App\Components\Signal\Entities\Signal;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Components\Signal\Emails\SignalMailer;
use App\Components\Signal\Shared\ErrorLog;

/**
 * Class SignalEventSubcriber
 * @package App\Components\Signal\Listeners
 */
class SignalEventSubcriber
{
    use ErrorLog;

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
                    $logData['errorLog'] = true;
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
        $sender = Config::get('mail.from', []);
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
        if (Config::get('signal.email.sent')) {
            try {
                unset($data['created_at']);
                $data['logMessage'] = $data['message'];
                unset($data['message']);

                Mail::to(Config::get('signal.email.sentTo'))->send(new SignalMailer($data));
            }
            catch (\Exception $e) {
                self::errorLog($e);
            }
        }
    }

    private function getLogData(array $log = [], $level = '', array $param = [])
    {
        $request       = (isset($log['request'])) ? $log['request'] : App::get('request');
        $userId        = (null !== Auth::id()) ? Auth::id() : 0;
        $agentLanguage = $this->toString($this->agent->languages());

        $logData = [
            'level'                   => $level,
            'message'                 => $log['message'],
            'request_full_url'        => $request->fullUrl() ? $request->fullUrl() : 'undefined',
            'request_url'             => $request->url() ? $request->url() : 'undefined',
            'request_uri'             => $request->path() ? $request->path() : 'undefined',
            'request_method'          => (App::get('request')->header('x-http-method-override')) ? App::get('request')->header('x-http-method-override') : $request->method(),
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

        if (isset($log['error'])) {
            if ($log['error'] instanceof \Exception) {
                $logData['error_get_message'] = ($log['error']->getMessage()) ? $log['error']->getMessage() : null;
                $logData['error_get_code']    = ($log['error']->getCode()) ? $log['error']->getCode() : null;
                $logData['error_get_file']    = ($log['error']->getFile()) ? $log['error']->getFile() : null;
                $logData['error_get_line']    = ($log['error']->getLine()) ? $log['error']->getLine() : null;
                $logData['error_get_trace']   = ($log['error']->getTraceAsString()) ? $log['error']->getTraceAsString() : null;
            }
        }

        return $logData;
    }
}
