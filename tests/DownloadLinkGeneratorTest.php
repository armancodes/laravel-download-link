<?php

namespace Armancodes\DownloadLink\Tests;

use Armancodes\DownloadLink\Facades\DownloadLinkGenerator;
use Armancodes\DownloadLink\Models\DownloadLink;
use Armancodes\DownloadLink\Models\DownloadLinkIpAddress;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class DownloadLinkGeneratorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function file_path_must_not_be_empty()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("File path must NOT be empty!");

        DownloadLinkGenerator::disk('public')->generate();
    }

    /** @test */
    public function disk_must_not_be_empty()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Disk must NOT be empty!");

        DownloadLinkGenerator::filePath('example.txt')->generate();
    }

    /** @test */
    public function disk_must_be_valid()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Disk is NOT valid!");

        DownloadLinkGenerator::disk('invalid-disk')->filePath('example.txt')->generate();
    }

    /** @test */
    public function throw_error_when_file_does_not_exist()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("File not found!");

        DownloadLinkGenerator::disk('public')->filePath('file-that-does-not-exists.txt')->generate();
    }

    /** @test */
    public function do_not_throw_error_when_file_exists()
    {
        $downloadLinkInstance = new \Armancodes\DownloadLink\DownloadLinkGenerator();

        Storage::fake('public')->put('example.txt', 'This is a test file');

        $downloadLink = $downloadLinkInstance->disk('public')->filePath('example.txt')->generate();

        $this->assertEquals($downloadLinkInstance::DOWNLOAD_LINK_NUMBER_OF_CHARACTERS, strlen($downloadLink));
    }

    /** @test */
    public function creates_download_link_in_database()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $this->assertNull(DownloadLink::first());

        $generatedLink = DownloadLinkGenerator::disk('public')->filePath('example.txt')->generate();

        $downloadLink = DownloadLink::first();

        $this->assertEquals($generatedLink, $downloadLink->link);
    }

    /** @test */
    public function save_ip_address_in_database_if_given()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $this->assertNull(DownloadLinkIpAddress::first());

        $limitedIp = '127.0.0.1';

        DownloadLinkGenerator::disk('public')->filePath('example.txt')->limitIp($limitedIp)->generate();

        $downloadLink = DownloadLink::first();

        $ipAddresses = DownloadLinkIpAddress::where('download_link_id', $downloadLink->id)
            ->where('ip_address', $limitedIp)
            ->where('allowed', false)
            ->first();

        $this->assertNotNull($ipAddresses);
    }

    /** @test */
    public function save_multiple_ip_addresses_in_database_if_given()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $this->assertNull(DownloadLinkIpAddress::first());

        $allowedIps = [
            '127.0.0.1',
            '127.0.0.2',
            '127.0.0.3',
        ];

        DownloadLinkGenerator::disk('public')->filePath('example.txt')->allowIp($allowedIps)->generate();

        $downloadLink = DownloadLink::first();

        $ipAddressesCount = DownloadLinkIpAddress::where('download_link_id', $downloadLink->id)
            ->whereIn('ip_address', $allowedIps)
            ->where('allowed', true)
            ->count();

        $this->assertEquals(3, $ipAddressesCount);
    }
}
