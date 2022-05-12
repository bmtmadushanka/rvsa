<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCopyPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_copy_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_copy_id');
            $table->unsignedTinyInteger('blueprint_id')->nullable();
            $table->longText('text')->nullable();
            $table->longText('html');
            $table->unsignedTinyInteger('sort_order');
            $table->softDeletes();
            $table->index(['master_copy_id'], 'INDEX');
            $table->foreign('master_copy_id', 'fk_mcp_mc_id')->references('id')->on('master_copies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_copy_pages');
    }
}
