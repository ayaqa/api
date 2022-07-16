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
        Schema::create(\AyaQA\Models\Playground\Checkbox::TABLE_NAME, function(Blueprint $table) {
            $table->id();
            $table->string('key', 100)->index('cb_key');
            $table->boolean('value')->default(0);
            $table->string('group')->nullable()->default(NULL)->index('cb_group_key');
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
        Schema::dropIfExists(\AyaQA\Models\Playground\Checkbox::TABLE_NAME);
    }
};
