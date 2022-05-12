<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordered_by');
            $table->decimal('sub_total', 11, 2);
            $table->decimal('discount', 4, 2);
            $table->decimal('total', 11, 2);
            $table->enum('status', ['paid', 'pending'])->default('pending');
            $table->timestamps();
            $table->index(['ordered_by', 'total', 'status'], 'INDEX');
            $table->foreign('ordered_by', 'fk_o_u_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
