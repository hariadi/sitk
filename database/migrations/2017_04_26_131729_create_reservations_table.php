<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reason')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->string('destination')->nullable();
            $table->unsignedInteger('approver_id')->nullable();
            $table->timestamp('approved_at')->nullable();
            //$table->nullableMorphs('reserved'); //for dynamic resevation like vehicle, meeting rooms, consider using morph
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->enum('status', ['Dalam Tindakan', 'Lulus', 'Ditolak'])->default('Dalam Tindakan');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
