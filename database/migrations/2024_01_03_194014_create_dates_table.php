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
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('sub_branch_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('device_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('sub_branch_id')->references('id')->on('sub_branches');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dates');
    }
};
