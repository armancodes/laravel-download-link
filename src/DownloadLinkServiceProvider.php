<?php

namespace Armancodes\DownloadLink;

use Armancodes\DownloadLink\Commands\DownloadLinkCommand;
use Illuminate\Support\ServiceProvider;

class DownloadLinkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/download-link.php' => config_path('download-link.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/download-link'),
            ], 'views');

            $migrationFileName = 'create_download_links_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                DownloadLinkCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'download-link');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/download-link.php', 'download-link');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
