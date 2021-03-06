<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/21/19 9:24 AM
 */

namespace App\Components\Signal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class Signal
 * @package App\Components\Signal\Entities
 */
class Signal extends Model
{
    /**
     * @var mixed|string
     */
    protected $table      = 'signal_log';

    /**
     * @var array
     */
    protected $fillable = [
        'level',
        'message',
        'request_full_url',
        'request_url',
        'request_uri',
        'request_method',
        'devices',
        'os',
        'os_version',
        'browser_name',
        'browser_version',
        'browser_accept_language',
        'robot',
        'client_ip',
        'error_uuid',
        'error_get_message',
        'error_get_code',
        'error_get_file',
        'error_get_line',
        'error_get_trace',
        'user_id',
    ];

    /**
     * Signal constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Config::get('signal.table');
    }
}
