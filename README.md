# signal

| Laravel   | signal  |
| ----------|:-------:|
| v5.4      | ~0.2    |
| v5.5      | ~0.3    |
| v5.7      | ~0.8    |
| v5.8      | ~1.0    |

The logger provides the eight logging levels defined in RFC 5424: _emergency_, _alert_, _critical_, _error_, _warning_, _notice_, _info_ and _debug_. Passing message into event and It will automatically detect request url, request method, client ip, browser, brower version, user OS etc and save it into database. The log data can be sent to user email by changing the configuration setting in config file.

## Install

```bash
composer require consigliere/signal
```

### Migration

```bash
php artisan vendor:publish --tag=migrations-signal
php artisan migrate
```

### Publish config

```bash
php artisan vendor:publish --tag=config-signal
```

## Basic

### Signal - using `event` helper
```php
event('signal.emergency', [$message]);
event('signal.alert', [$message,]);
event('signal.critical', [$message]);
event('signal.error', [$message]);
event('signal.warning', [$message]);
event('signal.notice', [$message]);
event('signal.info', [$message]);
event('signal.debug', [$message]);
```

### Signal - Using `Event` Facade
```php
use Illuminate\Support\Facades\Event;

Event::dispatch('signal.emergency', [$message]);
Event::dispatch('signal.alert', [$message]);
Event::dispatch('signal.critical', [$message]);
Event::dispatch('signal.error', [$message]);
Event::dispatch('signal.warning', [$message]);
Event::dispatch('signal.notice', [$message]);
Event::dispatch('signal.info', [$message]);
Event::dispatch('signal.debug', [$message]);
```

## Events Wrapper 

In the config, `log.activity` and specific logging control needs to be set as true.

### Wrapper

```php
$this->fireLog('emergency', $message);
$this->fireLog('alert', $message);
$this->fireLog('critical', $message);
$this->fireLog('error', $message);
$this->fireLog('warning', $message);
$this->fireLog('notice', $message);
$this->fireLog('info', $message);
$this->fireLog('debug', $message);
```

### Code Example 

```php
use App\Components\Signal\Traits\Signal;

class UserController extends Controller
{
    use Signal;

    public function profile(Request $request): \Illuminate\Http\JsonResponse
    {
        $data   = [];
        $option = $this->getOption();
        $param  = $this->getParam($this->type);

        try {
            $user = $this->userService->profile($data, $option, $param);
        } catch (\Exception $error) {
            # Provide $error instance of \Exception
            # Provide the uuid, upon empty, error uuid will be assigned automatically
            $this->fireLog('error', $error->getMessage(), ['error' => $error, 'uuid' => $this->euuid]);

            return $this->response($this->getErrorResponse($this->euuid, $error), 500);
        }

        return $this->response($user, 200);
    }
}
```

### Sent log data into multiple email recipient

Make sure the application can send an email by providing the correct data in `.env`.

```properties
MAIL_DRIVER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
```

Set the `LOG_ACTIVITY` and `SIGNAL_EMAIL_SENT` value to `true` in `.env`.
Provide user email data where it will be sent separated by a comma.

```properties
LOG_ACTIVITY=true
SIGNAL_EMAIL_SENT=true
SIGNAL_EMAIL_SENT_TO=email1@example.com,email2@example.com,etc@example.com
SIGNAL_USE_TABLE=signal_log

MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```
