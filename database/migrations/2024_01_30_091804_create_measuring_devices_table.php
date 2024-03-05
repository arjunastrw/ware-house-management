<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('measuring_devices', function (Blueprint $table) {
            $table->id();
            $table->string('no_control')->unique();
            $table->unsignedBigInteger('freq_cal_measuring_device_id')->nullable();
            $table->foreign('freq_cal_measuring_device_id')->references('id')->on('freq_cal_measuring_devices')->onDelete('set null');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
            $table->unsignedBigInteger('merk_id')->nullable();
            $table->foreign('merk_id')->references('id')->on('merks')->onDelete('set null');
            $table->string('no_seri')->nullable();
            $table->unsignedBigInteger('range_id')->nullable();
            $table->foreign('range_id')->references('id')->on('ranges')->onDelete('set null');
            $table->unsignedBigInteger('resolution_id')->nullable();
            $table->foreign('resolution_id')->references('id')->on('resolutions')->onDelete('set null');
            $table->date('ata_sai')->nullable();
            $table->string('inv_no')->nullable();
            $table->string('no_doc_bc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measuring_devices');
    }
};
