<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('provider_id')->comment('Data provider (Alpha Vantage, Quandl, EOD)');
            $table->smallInteger('country_id')->nullable()->default(null);
            $table->smallInteger('currency_id')->nullable()->default(null);
            $table->string('code', 8)->unique()->comment('ISO 10383 Code for Exchanges and Market Identification (MIC)');
            $table->string('name', 128)->nullable()->default(null);
            $table->string('mics', 64)->nullable()->default(null);
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
        Schema::dropIfExists('exchanges');
    }
}
