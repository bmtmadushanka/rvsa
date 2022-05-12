<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationVersionChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_version_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_new')->default(FALSE);
            $table->boolean('is_read')->default(FALSE);
            $table->unsignedBigInteger('child_copy_id');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'child_copy_id'], 'INDEX');
            $table->foreign('user_id', 'fk_nu_u_id')->references('id')->on('users');
            $table->foreign('child_copy_id', 'fk_nu_cc_id')->references('id')->on('child_copies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_version_changes');
    }
}
