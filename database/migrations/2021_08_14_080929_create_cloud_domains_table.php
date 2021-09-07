<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloudDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cloud_site_id');
            $table->integer('cloud_account_id');
            $table->string('zone_id');
            $table->string('name');
            $table->string('status');
            $table->string('security_level');
            $table->string('ssl_setting');
            $table->string('ipv6');
            $table->string('name_server1');
            $table->string('name_server2');
            $table->string('plan');
            $table->timestamps();
            $table->datetime('expire_date');
            $table->string('get_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cloud_domains');
    }
}
