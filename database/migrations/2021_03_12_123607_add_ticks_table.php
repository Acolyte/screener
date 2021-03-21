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
            $table->enum('timeframe', [TimeframeEnum::D, TimeframeEnum::W, TimeframeEnum::M, TimeframeEnum::Y])->default(TimeframeEnum::D);
            $table->decimal('open', 8, 6)->default(0.0);
            $table->double('close', 8, 6)->default(0.0);
            $table->double('low', 8, 6)->default(0.0);
            $table->double('high', 8, 6)->default(0.0);
            $table->unsignedBigInteger('volume')->default(0);
            $table->timestamp('created_at', 0)->nullable();
            $table->index('stock_id');
            $table->index(['stock_id', 'timeframe']);
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
