<?php

namespace App\Providers;
use Illuminate\Support\Facades\DB;
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
        DB::listen(function ($query) {
            /*$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 50);

            // پیدا کردن اولین خطی از پروژه که در vendor نیست
            $caller = collect($trace)->first(function ($trace) {
                return isset($trace['file']) &&
                       strpos($trace['file'], '/vendor/') === false &&
                       strpos($trace['file'], 'ServiceProvider') === false;
            });*/

            /*echo "<pre>";
            print_r([
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time(ms)' => $query->time,
                'executed_at' => $caller['file'] . ':' . $caller['line'] ?? 'unknown'
            ]);
            echo "</pre>";*/
        });
    }
}
