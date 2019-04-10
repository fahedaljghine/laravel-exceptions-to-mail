<?php

namespace Fahedaljghine\ErrorsMail\Exceptions;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Fahedaljghine\ErrorsMail\Mail\ExceptionOccurred;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Exception;
use Mail;
use Config;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];


    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendEmail($exception); // sends an email
        }

        parent::report($exception);
    }


    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            $errors["auth"] = 1;
            request()->session()->flash("flash_notification", ["level" => "danger", "message" => "عزيزي المستخدم لقد انتهى وقت الجلسة !"]);

            return response()->json($errors, 422);
        }

        if ($request->ajax()) {
            $errors["auth"] = 1;
            request()->session()->flash("flash_notification", ["level" => "danger", "message" => "عزيزي المستخدم لقد انتهى وقت الجلسة !"]);

            return response()->json($errors, 422);
        }

        return redirect()->guest(route('login'));
    }

    public function sendEmail(Exception $exception)
    {
        try {
            $e = FlattenException::create($exception);

            $handler = new SymfonyExceptionHandler();

            $html = $handler->getHtml($e);

            $mails = Config::get('errors-mail.mails', []);

            Mail::to($mails)->send(new ExceptionOccurred($html));

        } catch (Exception $ex) {
        }
    }
}
