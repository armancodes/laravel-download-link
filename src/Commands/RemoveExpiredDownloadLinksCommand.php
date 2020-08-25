<?php

namespace Armancodes\DownloadLink\Commands;

use Armancodes\DownloadLink\Models\DownloadLink;
use Illuminate\Console\Command;

class RemoveExpiredDownloadLinksCommand extends Command
{
    public $signature = 'download-links:remove-expired';

    public $description = 'Remove expired download links';

    public function handle()
    {
        $deletedDownloadLinks = DownloadLink::where('expire_time', '<', now())->delete();

        if (! $deletedDownloadLinks) {
            $this->warn('No expired download link found!');
            return;
        }

        $this->comment('Expired download links removed successfully!');
    }
}
