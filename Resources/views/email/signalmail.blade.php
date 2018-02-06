@extends('signal::layouts.signalmail-master')

@section('content')
    <h1>Log Level : {{ $level }}</h1>

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
            @isset($getMessage)
                <p>Message : {{ $getMessage }}</p>
            @endisset

            @isset($getCode)
                <p>Code : {{ $getCode }}</p>
            @endisset

            @isset($getFile)
                <p>File : {{ $getFile }}</p>
            @endisset

            @isset($getLine)
                <p>Line : {{ $getLine }}</p>
            @endisset

            @isset($getTraceAsString)
                <p>Trace : {{ $getTraceAsString }}</p>
            @endisset
        @endif
    @endisset

@stop
