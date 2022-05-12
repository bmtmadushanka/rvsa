<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(TRUE);
            $table->unsignedBigInteger('make_id');
            $table->string('name');
            $table->softDeletes();
            $table->index(['is_active', 'make_id', 'name'], 'INDEX');
            $table->foreign('make_id', 'fk_vm_m_id')->references('id')->on('vehicle_makes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_models');
    }
}
