<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approver_id')->references('id')->on('users');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('driver_id')->references('id')->on('drivers');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['approver_id']);
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['driver_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
    }
}
