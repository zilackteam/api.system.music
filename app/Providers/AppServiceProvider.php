<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Validator;
use App\Libs\MimeReader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('audio', function($attribute, $value, $parameters) {
            $allowed = ['audio/mpeg', 'application/ogg', 'audio/wave', 'audio/aiff'];
            $mime = new MimeReader($value->getRealPath());
            return in_array($mime->get_type(), $allowed);
        });

        Validator::extend('tokenForgotPassword', function($attribute, $value, $parameters) {
            $request = \DB::table('password_resets')->where('token', $value)->first();

            return ( $request && $request->created_at > Carbon::now()->subHours(1) );
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
