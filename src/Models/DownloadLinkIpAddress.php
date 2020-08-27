<?php

namespace Armancodes\DownloadLink\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadLinkIpAddress extends Model
{
    protected $guarded = ['id'];

    protected $table = "download_link_ip_addresses";

    public $timestamps = false;

    public function downloadLink()
    {
        return $this->belongsTo(DownloadLink::class);
    }
}
