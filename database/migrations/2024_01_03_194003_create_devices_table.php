<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('accossories')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('processor_id')->nullable();
            $table->unsignedBigInteger('memory1_id')->nullable();
            $table->unsignedBigInteger('memory2_id')->nullable();
            $table->unsignedBigInteger('hard_disk1_id')->nullable();
            $table->unsignedBigInteger('hard_disk2_id')->nullable();
            $table->timestamps();
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('processor_id')->references('id')->on('processors');
            $table->foreign('memory1_id')->references('id')->on('memories');
            $table->foreign('memory2_id')->references('id')->on('memories');
            $table->foreign('hard_disk1_id')->references('id')->on('hard_disks');
            $table->foreign('hard_disk2_id')->references('id')->on('hard_disks');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
