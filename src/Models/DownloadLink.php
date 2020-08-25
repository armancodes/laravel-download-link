<?php

namespace Armancodes\DownloadLink\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadLink extends Model
{
    protected $guarded = ['id'];

    protected $table = "download_links";

    public function ipAddresses()
    {
        return $this->hasMany(DownloadLinkIpAddress::class);
    }
}