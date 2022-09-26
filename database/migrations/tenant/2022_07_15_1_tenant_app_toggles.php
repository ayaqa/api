<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\AyaQA\Models\Playground\Toggle::TABLE_NAME, function(Blueprint $table) {
            $table->id();
            $table->string('key', 100)->index('tg_key');
            $table->boolean('value')->default(0);
            $table->string('group')->nullable()->default(NULL)->index('tg_group_key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\AyaQA\Models\Playground\Toggle::TABLE_NAME);
    }
};
