<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * オリジナルデザインのエラー画面をレンダリングする
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Illuminate\Http\Response
     */
    protected function renderHttpException(\Symfony\Component\HttpKernel\Exception\HttpException $e)
    {

        $status = $e->getStatusCode();
        return response()->view(
            "errors.common", // 共通テンプレート
            [
            // VIEWに与える変数
                'exception' => $e,
                'message' => $e->getMessage(),
                'status_code' => $status,
            ],
            $status, // レスポンス自体のステータスコード
            $e->getHeaders()
        );
    }
}
