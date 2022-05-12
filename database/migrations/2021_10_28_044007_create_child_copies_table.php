<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_copies', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(FALSE);
            $table->boolean('is_readonly')->default(FALSE);
            $table->boolean('is_indexed')->default(FALSE);
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('master_copy_id');
            $table->string('version', 13);
            $table->string('approval_code')->nullable();
            $table->string('name');
            $table->string('make');
            $table->string('model');
            $table->string('model_code');
            $table->string('description');
            $table->unsignedBigInteger('created_by');
            $table->decimal('price', 11, 2);
            $table->longText('data');
            $table->longText('indexes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['is_active', 'is_readonly', 'batch_id', 'name', 'make', 'model'], 'INDEX1');
            $table->index(['model_code', 'created_by', 'price'], 'INDEX');
            $table->foreign('master_copy_id', 'fk_cc_mc_id')->references('id')->on('master_copies');
            $table->foreign('created_by', 'fk_cc_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_copies');
    }
}
