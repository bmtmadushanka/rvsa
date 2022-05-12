<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRecallCheckLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_recall_check_links', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(TRUE);
            $table->string('name', 2048);
            $table->index(['is_active'], 'INDEX');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_recall_check_links');
    }
}
