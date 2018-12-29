<?php

namespace App\Components\Signal\Entities;

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
        "error_get_message",
        "error_get_code",
        "error_get_file",
        "error_get_line",
        "error_get_trace",
        "user_id",
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('signal.table');
    }
}
