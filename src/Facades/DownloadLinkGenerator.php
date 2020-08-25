<?php

namespace Armancodes\DownloadLink\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Armancodes\DownloadLink\DownloadLinkGenerator
 */
class DownloadLinkGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'downloadLinkGenerator';
    }
}
