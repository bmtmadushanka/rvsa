<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('status', ['paid', 'failed', 'pending'])->default('pending');
            $table->string('token');
            $table->decimal('gross_amount', 11, 2);
            $table->decimal('paypal_fee', 11, 2)->nullable();
            $table->decimal('net_amount', 11, 2)->nullable();
            $table->text('response')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->index(['order_id', 'gross_amount', 'paypal_fee', 'net_amount', 'status', 'token'], 'INDEX');
            $table->foreign('order_id', 'fk_op_o_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_payments');
    }
}
