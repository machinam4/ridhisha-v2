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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string("TransactionType")->nullable();
            $table->string("TransID")->nullable();
            $table->dateTime("TransTime")->nullable();
            $table->integer("TransAmount")->nullable();
            $table->string("BusinessShortCode")->nullable();
            $table->string("BillRefNumber")->nullable();
            $table->string("InvoiceNumber")->nullable();
            $table->integer("OrgAccountBalance")->nullable();
            $table->string("ThirdPartyTransID")->nullable();
            $table->string("MSISDN")->nullable();
            $table->string("FirstName")->nullable();
            $table->integer("user_id")->default(1);
            $table->integer("session_id")->default(0);
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
        Schema::dropIfExists('players');
    }
};
