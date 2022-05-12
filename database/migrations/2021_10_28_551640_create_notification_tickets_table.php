<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_tickets', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_closed')->default(FALSE);
            $table->boolean('is_read_sender')->default(TRUE);
            $table->boolean('is_read_assignee')->default(FALSE);
            $table->unsignedBigInteger('order_report_id')->nullable();
            $table->string('subject', 100);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('assignee')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
            $table->index(['is_closed', 'is_read_sender', 'is_read_assignee', 'order_report_id', 'created_by', 'assignee', 'created_at'], 'INDEX');
            $table->foreign('order_report_id', 'fk_nt_or_id')->references('id')->on('order_reports');
            $table->foreign('created_by', 'fk_nt_cb_id')->references('id')->on('users');
            $table->foreign('assignee', 'fk_nt_as_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_tickets');
    }
}
