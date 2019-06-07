<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 全角半角を考慮したバリデーション
         * 全角1 半角0.5
         */
        Validator::extend('full_harf_width_max', function ($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('full_harf_width_max', function ($message, $attribute, $rule, $parameters) {
                return str_replace([':max'], $parameters, $message);
            });
            return (mb_strwidth($value) / 2) <= $parameters[0];
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
