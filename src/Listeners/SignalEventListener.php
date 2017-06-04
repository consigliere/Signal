<?php
/**
 * SignalEventListener.php
 * Created by @anonymoussc on 6/3/2017 11:03 PM.
 */

namespace App\Components\Signal\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Components\Signal\Models\Signal;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SignalEventListener
{
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
        $events->listen('event.emergency', 'App\Components\Signal\Listeners\SignalEventListener@onEmergency', 10);
        $events->listen('event.alert', 'App\Components\Signal\Listeners\SignalEventListener@onAlert', 10);
        $events->listen('event.critical', 'App\Components\Signal\Listeners\SignalEventListener@onCritical', 10);
        $events->listen('event.error', 'App\Components\Signal\Listeners\SignalEventListener@onError', 10);
        $events->listen('event.warning', 'App\Components\Signal\Listeners\SignalEventListener@onWarning', 10);
        $events->listen('event.notice', 'App\Components\Signal\Listeners\SignalEventListener@onNotice', 10);
        $events->listen('event.info', 'App\Components\Signal\Listeners\SignalEventListener@onInfo', 10);
        $events->listen('event.debug', 'App\Components\Signal\Listeners\SignalEventListener@onDebug', 10);
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onEmergency(array $log, $level = 'emergency')
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
            'browser_accept_language' => $this->agent->languages(),
            'robot'                   => $this->agent->robot(),
            'client_ip'               => $request->ip(),
            'user_id'                 => $userId,
            'created_at'              => Carbon::now(),
        ];

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onAlert(array $log, $level = 'alert')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onCritical(array $log, $level = 'critical')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onError(array $log, $level = 'error')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onWarning(array $log, $level = 'warning')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onNotice(array $log, $level = 'notice')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;
    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onInfo(array $log, $level = 'info')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return true;

    }

    /**
     * @param array  $log
     * @param string $level
     *
     * @return bool
     */
    public function onDebug(array $log, $level = 'debug')
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

        try {
            $records = Signal::insert($logData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
        Mail::queue($view, $data, function ($message) use ($email, $subject, $sender) {
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
}