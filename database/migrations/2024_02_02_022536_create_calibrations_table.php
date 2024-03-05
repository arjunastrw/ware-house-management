<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('shift')->nullable();
            $table->unsignedBigInteger('measuring_device_id')->nullable();
            $table->foreign('measuring_device_id')->references('id')->on('measuring_devices')->onDelete('set null');
            $table->date('expired_date')->nullable();
            $table->string('con_before_cal');
            $table->string('con_after_cal');
            $table->date('cal_date')->nullable();
            $table->string('cal_supplier')->nullable();
            $table->string('no_certificate');
            $table->string('file1')->nullable();
            $table->String('file2')->nullable();
            $table->string('result')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            $table->unsignedBigInteger('carname_id')->nullable();
            $table->foreign('carname_id')->references('id')->on('carnames')->onDelete('set null');
            $table->string('service_place')->nullable();
            $table->date('start_ser_date')->nullable();
            $table->date('finish_ser_date')->nullable();
            $table->string('problem')->nullable();
            $table->date('life_time')->nullable();
            $table->string('next_action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibrations');
    }
};
