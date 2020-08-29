<?php

use Armancodes\DownloadLink\Http\Controllers\DownloadLinkController;
use Illuminate\Support\Facades\Route;

Route::get(config('download-link.download_route') . '/{link}', [DownloadLinkController::class, 'download'])->name('download-link.download-route');
