@extends('signal::layouts.signalmail-master')

@section('content')
    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Your {{ $level }} notification has arrived.</span>
    <h1>{{ $level }}</h1>

    <p>Message : {{ $logMessage }}</p>
    <p>Request full url : {{ $request_full_url }}</p>
    <p>Request Url : {{ $request_url }}</p>
    <p>Request Uri : {{ $request_uri }}</p>
    <p>Request method : {{ $request_method }}</p>
    <p>devices : {{ $devices }}</p>
    <p>OS : {{ $os }}</p>
    <p>OS Version : {{ $os_version }}</p>
    <p>Browser Name : {{ $browser_name }}</p>
    <p>Browser Version : {{ $browser_version }}</p>
    <p>Browser Accept Language : {{ $browser_accept_language }}</p>
    <p>Robot : {{ $robot }}</p>
    <p>Client IP : {{ $client_ip }}</p>
    <p>User ID : {{ $user_id }}</p>

    @isset($errorLog)
        @if ($errorLog === true)
            <p>StackTrace : </p>
            @isset($error_uuid)
                <p>Error Id : {{ $error_uuid }}</p>
            @endisset
            @isset($error_get_message)
                <p>Message : {{ $error_get_message }}</p>
            @endisset

            @isset($error_get_code)
                <p>Code : {{ $error_get_code }}</p>
            @endisset

            @isset($error_get_file)
                <p>File : {{ $error_get_file }}</p>
            @endisset

            @isset($error_get_line)
                <p>Line : {{ $error_get_line }}</p>
            @endisset

            @isset($error_get_trace)
                <p>Trace : {{ $error_get_trace }}</p>
            @endisset
        @endif
    @endisset

@stop
