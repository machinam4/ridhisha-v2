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
        Schema::create('mpesas', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('shortcode')->unique();
            $table->string('name');
            $table->string('username');
            $table->string('key');
            $table->string('secret');
            $table->string('passkey')->nullable();
            $table->string('b2cPassword')->nullable();
            $table->integer('radio_id')->default(1);
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
        Schema::dropIfExists('mpesas');
    }
};
