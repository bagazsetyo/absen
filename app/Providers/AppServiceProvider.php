<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('responseSuccess', function ($data, $message = 'OK') {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => $message,
            ], 200);
        });

        Response::macro('responseError', function ($message = 'Bad Request', $code = 400) {
            return response()->json([
                'code' => $code,
                'message' => $message,
            ], $code);
        });

        Response::macro('responseMessage', function ($message = 'Bad Request', $code = 200) {
            return response()->json([
                'code' => $code,
                'message' => $message,
            ], $code);
        });

    }
}
