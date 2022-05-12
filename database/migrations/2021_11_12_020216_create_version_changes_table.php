<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_changes', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 25);
            $table->unsignedBigInteger('model_id');
            $table->enum('reference_type', ['main', 'adr'])->nullable();
            $table->unsignedBigInteger('parent_id');
            $table->longText('data');
            $table->index(['reference_type', 'parent_id'], 'INDEX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('version_changes');
    }
}
