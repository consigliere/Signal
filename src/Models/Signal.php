<?php
/**
 * Signal.php
 * Created by @anonymoussc on 6/3/2017 11:07 PM.
 */

namespace App\Components\Signal\Models;

use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    protected $table      = 'sg_log';
    protected $primaryKey = 'id';
    protected $fillable   = [
        "level",
        "message",
        "request_full_url",
        "request_url",
        "request_uri",
        "request_method",
        "devices",
        "os",
        "os_version",
        "browser_name",
        "browser_version",
        "browser_accept_language",
        "robot",
        "client_ip",
    ];
}
