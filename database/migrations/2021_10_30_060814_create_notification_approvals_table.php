<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_approvals', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_approved')->default(FALSE);
            $table->boolean('is_read_user')->default(TRUE);
            $table->boolean('is_read_admin')->default(FALSE);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->text('fields');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->index(['is_approved', 'is_read_user', 'is_read_admin', 'created_by', 'reviewed_by', 'created_at'], 'INDEX');
            $table->foreign('created_by', 'fk_na_cb_id')->references('id')->on('users');
            $table->foreign('reviewed_by', 'fk_na_rb_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_approvals');
    }
}
