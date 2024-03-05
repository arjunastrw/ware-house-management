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
        Schema::create('freq_cal_measuring_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->unique();
            $table->enum('cal_status', ['Internal', 'External']);
            $table->unsignedBigInteger('freq_cal_num');
            $table->unsignedBigInteger('life_time_num');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freq_cal_measuring_devices');
    }
};
