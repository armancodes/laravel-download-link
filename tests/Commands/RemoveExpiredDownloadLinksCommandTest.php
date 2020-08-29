<?php

namespace Armancodes\DownloadLink\Tests;

use Armancodes\DownloadLink\Commands\RemoveExpiredDownloadLinksCommand;
use Armancodes\DownloadLink\Facades\DownloadLinkGenerator;
use Armancodes\DownloadLink\Models\DownloadLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class RemoveExpiredDownloadLinksCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function file_path_must_not_be_empty()
    {
        $command = new RemoveExpiredDownloadLinksCommand;

        Storage::fake('public')->put('example.txt', 'This is a test file');

        $this->assertEquals(0, DownloadLink::count());

        DownloadLinkGenerator::disk('public')->filePath('example.txt')->expire(now()->addMinute())->generate();
        DownloadLinkGenerator::disk('public')->filePath('example.txt')->expire(now()->subMinute())->generate();

        $this->assertEquals(2, DownloadLink::count());

        $this->artisan($command->signature);

        $this->assertEquals(1, DownloadLink::count());
    }
}
