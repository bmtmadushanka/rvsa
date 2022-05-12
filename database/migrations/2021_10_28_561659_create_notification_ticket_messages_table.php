<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTicketMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_ticket_id');
            $table->string('token', 40);
            $table->text('message');
            $table->string('file')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
            $table->index(['token'], 'INDEX');
            $table->foreign('created_by', 'fk_ntm_cb_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_ticket_messages');
    }
}
