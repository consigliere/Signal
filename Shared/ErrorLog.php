<?php
/**
 * ErrorLog.php
 * Created by @anonymoussc on 01/28/2018 3:57 AM.
 */

namespace App\Components\Signal\Shared;

use Illuminate\Support\Facades\Log;

/**
 * Trait ErrorLog
 * @package App\Components\Signal\Shared
 */
trait ErrorLog
{
    /**
     * @param $error
     */
    public function errorLog($error): void
    {
        Log::error($error->getMessage());
        Log::error($error->getCode());
        Log::error($error->getFile());
        Log::error($error->getLine());
        Log::error($error->getTraceAsString());
    }
}
