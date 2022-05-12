<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('activity_id');
            $table->unsignedBigInteger('reference')->nullable();
            $table->string('remark', 161)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'activity_id', 'reference', 'created_at'], 'INDEX');
            $table->foreign('user_id', 'fk_ul_u_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
}
