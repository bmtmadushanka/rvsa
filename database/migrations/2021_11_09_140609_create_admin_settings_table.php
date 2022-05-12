<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('id');
            $table->string('company_name');
            $table->char('company_code', 10);
            $table->string('company_acn');
            $table->string('company_test_facility_id');
            $table->tinyText('company_address');
            $table->string('company_contact_no', 15);
            $table->string('company_email')->unique();
            $table->string('company_logo');
            $table->string('company_web');
            $table->string('default_raw_id');
            $table->string('default_raw_company_name');
            $table->string('default_abn');
            $table->tinyText('default_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_settings');
    }
}
