<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildCopyModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_copy_mods', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(TRUE);
            $table->unsignedBigInteger('child_copy_id');
            $table->unsignedTinyInteger('variant_id');
            $table->longText('pre')->nullable();
            $table->longText('post')->nullable();
            $table->longText('post_visible_columns')->nullable();
            $table->unsignedTinyInteger('sort_order')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['is_active', 'child_copy_id', 'variant_id', 'sort_order'], 'INDEX');
            $table->foreign('child_copy_id', 'fk_chm_cc_id')->references('id')->on('child_copies');
            $table->foreign('created_by', 'fk_chm_cb_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_copy_mods');
    }
}
