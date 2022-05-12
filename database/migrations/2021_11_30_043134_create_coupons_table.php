<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(TRUE);
            $table->boolean('is_redeemed')->default(FALSE);
            $table->enum('type', ['one-off', 'indefinite'])->default('one-off');
            $table->string('code', 6);
            $table->decimal('discount', 4,2);
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('redeemed_at')->nullable();
            $table->softDeletes();
            $table->index(['is_active', 'is_redeemed', 'code', 'discount', 'valid_from', 'valid_to'], 'INDEX');
            $table->foreign('created_by', 'fk_c_c_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
