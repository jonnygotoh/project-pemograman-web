<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

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
        $dbName = 'sertifikasi_uib';

        /*
        |--------------------------------------------------------------------------
        | AUTO UPDATE .ENV
        |--------------------------------------------------------------------------
        */

        $envPath = base_path('.env');

        if (file_exists($envPath)) {

            $env = file_get_contents($envPath);
            $env = preg_replace(
                '/DB_DATABASE=.*/',
                'DB_DATABASE=' . $dbName,
                $env
            );

            file_put_contents($envPath, $env);
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE DATABASE IF NOT EXISTS
        |--------------------------------------------------------------------------
        */

        try {

            Config::set('database.connections.mysql.database', null);
            DB::purge('mysql');
            DB::statement("CREATE DATABASE IF NOT EXISTS `$dbName`");
            Config::set('database.connections.mysql.database', $dbName);
            DB::reconnect('mysql');

        } catch (\Exception $e) {

            // optional debug
            // dd($e->getMessage());

        }
    }
}