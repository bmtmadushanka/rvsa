<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adrs', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(TRUE);
            $table->string('number', 10);
            $table->string('name');
            $table->longText('text');
            $table->longText('html');
            $table->longText('evidence')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->index(['is_active', 'number', 'name'], 'INDEX');
            $table->foreign('created_by', 'fk_adr_cb_id')->references('id')->on('users');
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
        Schema::dropIfExists('adrs');
    }
}
