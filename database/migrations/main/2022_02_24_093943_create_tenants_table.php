<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->uuid('session')->unique();
            $table->string('database')->unique();
            $table->enum('state', ['created', 'provisioning', 'failed', 'ready', 'deleting']);
            $table->timestamps();
        });
    }
};
