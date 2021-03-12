<?php

use App\Enum\TimeframeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticks', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->foreignId('stock_id')->nullable();
            $table->unsignedSmallInteger('timeframe')->default(TimeframeEnum::daily()->value);
            $table->double('open')->default(0.0);
            $table->double('close')->default(0.0);
            $table->double('low')->default(0.0);
            $table->double('high')->default(0.0);
            $table->double('volume')->default(0.0);
            $table->timestamp('created_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticks');
    }
}
