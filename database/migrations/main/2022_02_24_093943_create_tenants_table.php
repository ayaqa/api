<?php

use AyaQA\Enum\Core\TenantState;
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
            $table->enum('state', array_column(TenantState::cases(), 'value'));

            $table->boolean('deletable')->default(1);
            $table->timestamp('requested_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
