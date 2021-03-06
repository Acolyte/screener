<?php

use App\Enum\StockEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exchange_id');
            $table->string('sub_exchange')->nullable(true)->default(null);
            $table->string('code', 16)->index();
            $table->enum('type', array_values(config('enums.stock')))->default(StockEnum::commonStock()->toId());
            $table->string('name', 256);
            $table->boolean('active')->default(true);
            $table->date('ipo_at')->nullable()->default(null);
            $table->date('delisted_at')->nullable()->default(null);
            $table->timestamps();
            $table->index(['code', 'type']);
            $table->index(['exchange_id', 'code', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
