<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_reports', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_paid')->default(FALSE);
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('child_copy_id');
            $table->string('vin', 17);
            $table->decimal('price', 11,'2');
            $table->timestamps();
            $table->index(['is_paid', 'child_copy_id', 'vin', 'price'],'INDEX');
            $table->foreign('child_copy_id', 'fk_or_cp_id')->references('id')->on('child_copies');
            $table->foreign('order_id', 'fk_or_o_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_reports');
    }
}
