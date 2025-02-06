<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            //phone number  and email address
            $table->string('phone');
            $table->string('email');
            //opening hours
            $table->time('open_time');

            $table->time('close_time');
            $table->string('website')->nullable();
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->string('specialist')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
