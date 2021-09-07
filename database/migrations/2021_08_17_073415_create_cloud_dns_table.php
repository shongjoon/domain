<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloudDnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_dns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cloud_account_id');
            $table->integer('cloud_domain_id');
            $table->string('zone_id');
            $table->string('dns_id');
            $table->string('type');
            $table->string('name');
            $table->string('content');
            $table->integer('proxiable');
            $table->integer('proxied');
            $table->integer('ttl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cloud_dns');
    }
}
