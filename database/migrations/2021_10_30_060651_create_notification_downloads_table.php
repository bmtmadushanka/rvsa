<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_downloads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_report_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['report', 'consumer', 'adrs'])->default('report');
            $table->timestamp('downloaded_at')->useCurrent();
            $table->index(['order_report_id', 'user_id', 'downloaded_at'], 'INDEX');
            $table->foreign('order_report_id', 'fk_np_or_id')->references('id')->on('order_reports');
            $table->foreign('user_id', 'fk_nd_u_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_downloads');
    }
}
