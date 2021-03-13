<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table)
        {
            $table->id();
            $table->string('code', 32)->comment('Data provider code (av, eod)');
            $table->string('name', 128)->comment('Data provider name (Alpha Vantage, Quandl, EOD)');
            $table->string('site', 128)->comment('Data provider official site');
            $table->string('key', 128)->nullable()->comment('Data provider API key');
            $table->unique(['name', 'site', 'key']);
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
        Schema::dropIfExists('providers');
    }
}
