<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildCopyAdrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_copy_adrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_copy_id');
            $table->unsignedBigInteger('parent_adr_id');
            $table->boolean('is_common_adr')->default(FALSE);
            $table->string('number', 10);
            $table->string('name');
            $table->longText('text');
            $table->longText('html');
            $table->longText('evidence')->nullable();
            $table->string('pdf')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->index(['child_copy_id', 'number'], 'INDEX');
            $table->foreign('parent_adr_id', 'fk_cca_p_id')->references('id')->on('adrs');
            $table->foreign('child_copy_id', 'fk_cca_cc_id')->references('id')->on('child_copies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_copy_adrs');
    }
}
