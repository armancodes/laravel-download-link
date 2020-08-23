<?php

namespace Armancodes\DownloadLink;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Armancodes\DownloadLink\DownloadLink
 */
class DownloadLinkFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'downloadLink';
    }
}
