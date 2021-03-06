<?php

use App\Enum\TimeframeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicksTable extends Migration
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
            $table->bigInteger('stock_id')->nullable(false);
            $table->date('date')->nullable(false);
            $table->enum('timeframe', array_values(config('enums.timeframe')))->default(TimeframeEnum::d()->toId());
            $table->decimal('open', 12, 6)->default(0.0);
            $table->decimal('close', 12, 6)->default(0.0);
            $table->decimal('low', 12, 6)->default(0.0);
            $table->decimal('high', 12, 6)->default(0.0);
            $table->unsignedBigInteger('volume')->default(0);
            $table->timestamps();
            $table->index('stock_id');
            $table->index(['stock_id', 'date']);
            $table->index(['stock_id', 'timeframe', 'date']);
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
