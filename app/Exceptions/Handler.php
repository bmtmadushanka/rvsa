<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        AuthenticationException::class
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    private $endpoint = 'https://api.telegram.org/bot1457245584:AAFGIFPUbJa_bedfQSy3gO03p239RXrCcqM/';
    private $chat_id = '1422858418';

    public function report(Throwable $exception)
    {
        parent::report($exception);

        if ($this->shouldReport($exception) && ! app()->runningInConsole()){

            $action = app('request')->route()->getAction();
            list($controller, $action) = explode('@', $action['controller']);

            $user = Auth::user();

            $message = "App: " . config('app.code') . "\n\n";
            $message .= "Request URL: " . url()->current() . "\n";
            $message .= "Remote Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
            if ($user) {
                $message .= "User: {$user->name} ({$user->email}) \n";
            }
            $message .= "Controller: " . str_replace("App\Http\Controllers\\", "", $controller) . "\n";
            $message .= "Method: " . $action . "()\n";
            $message .= "File: " . $exception->getFile() . "\n";
            $message .= "Line No: {$exception->getLine()} \n\n";

            if ($exception->getMessage()) {
                $message .= "Message: {$exception->getMessage()}\n\n";
            }
            preg_match('/#0.+/', $exception->getTraceAsString(), $matches);
            if (! $exception->getTraceAsString()) {
                $message .= "Stack Trace: " . $matches[0];
            }


            $url = $this->endpoint . "sendMessage";
            $postData = 'chat_id=' . $this->chat_id . '&text=' . urlencode($message);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $output = curl_exec($ch);
            curl_close($ch);
            return $output;

        }
    }

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest('login');
    }

}
