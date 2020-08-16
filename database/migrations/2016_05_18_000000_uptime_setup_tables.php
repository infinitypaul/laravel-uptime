<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UptimeSetupTables extends Migration
{
    public function up()
    {
        Schema::create(config('uptime.endpoints_table'), function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('uri');
            $table->integer('frequency');
            $table->timestamps();
        });

        Schema::create(config('uptime.statuses_table'), function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('endpoint_id')->unsigned();
            $table->integer('status_code');
            $table->timestamps();

            $table->foreign('endpoint_id')
                ->references('id')
                ->on(config('uptime.endpoints_table'))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('uptime.endpoints_table'));
        Schema::drop(config('uptime.statuses_table'));
    }
}
