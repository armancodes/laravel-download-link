<?php

namespace Armancodes\DownloadLink\Tests\Http\Controllers;

use Armancodes\DownloadLink\Facades\DownloadLinkGenerator;
use Armancodes\DownloadLink\Tests\Models\User;
use Armancodes\DownloadLink\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class DownloadLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aborts_404_if_the_link_is_not_found()
    {
        $this->get(route('download-link.download-route', 'invalid-link'))->assertNotFound();
    }

    /** @test */
    public function aborts_404_if_the_file_is_not_found()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->generate();

        Storage::fake('public')->delete('example.txt');

        $this->get(route('download-link.download-route', $link))->assertNotFound();
    }

    /** @test */
    public function aborts_401_if_auth_only_and_it_is_not_authenticated()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->auth()->generate();

        $this->get(route('download-link.download-route', $link))->assertStatus(401);
    }

    /** @test */
    public function aborts_403_if_guest_only_and_it_is_not_a_guest()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $user = factory(User::class)->create();

        auth()->login($user);

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->guest()->generate();

        $this->get(route('download-link.download-route', $link))->assertStatus(403);
    }

    /** @test */
    public function aborts_403_if_link_is_expired()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->expire(now()->subMinute())->generate();

        $this->get(route('download-link.download-route', $link))->assertStatus(403);
    }

    /** @test */
    public function aborts_403_if_ip_is_not_in_whitelist()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->allowIp('127.0.0.2')->generate();

        $this->get(route('download-link.download-route', $link))->assertStatus(403);
    }

    /** @test */
    public function aborts_403_if_ip_is_in_blacklist()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->limitIp(request()->ip())->generate();

        $this->get(route('download-link.download-route', $link))->assertStatus(403);
    }

    /** @test */
    public function downloads_the_file_successfully()
    {
        Storage::fake('public')->put('example.txt', 'This is a test file');

        $link = DownloadLinkGenerator::disk('public')->filePath('example.txt')->generate();

        $this->get(route('download-link.download-route', $link))
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/plain');
    }
}
