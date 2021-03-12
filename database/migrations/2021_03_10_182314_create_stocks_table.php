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
            $table->string('symbol', 16)->index();
            $table->unsignedSmallInteger('type')->default(StockEnum::stock()->value);
            $table->string('name', 256);
            $table->boolean('active')->default(true);
            $table->date('ipoAt');
            $table->date('delistedAt')->nullable()->default(null);
            $table->timestamps();
            $table->index(['symbol', 'type']);
            $table->index(['exchange_id', 'symbol', 'type']);
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
