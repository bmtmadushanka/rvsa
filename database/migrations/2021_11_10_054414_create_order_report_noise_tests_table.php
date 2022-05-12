<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReportNoiseTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_report_noise_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_report_id');
            $table->text('data');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['order_report_id'], 'INDEX');
            $table->foreign('order_report_id', 'fk_ornt_or_id')->references('id')->on('order_reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_report_noise_tests');
    }
}
