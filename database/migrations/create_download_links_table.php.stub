<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadLinksTable extends Migration
{
    public function up()
    {
        Schema::create('download_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('link')->unique();
            $table->string('disk');
            $table->string('file_path');
            $table->string('file_name');
            $table->boolean('auth_only');
            $table->boolean('guest_only');
            $table->dateTime('expire_time')->nullable();
            $table->timestamps();
        });

        Schema::create('download_link_ip_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('download_link_id')->constrained()->onDelete('cascade');
            $table->ipAddress('ip_address');
            $table->boolean('allowed');
        });
    }

    public function down()
    {
        Schema::dropIfExists('download_links');
        Schema::dropIfExists('download_link_ip_address');
    }
}
