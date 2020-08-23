<?php

namespace Armancodes\DownloadLink\Commands;

use Illuminate\Console\Command;

class DownloadLinkCommand extends Command
{
    public $signature = 'downloadLink';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
