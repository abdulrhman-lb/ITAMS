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
        Schema::create('itams_employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('mobile');
            $table->string('ena');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('sub_branch_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('jop_title_id');
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('itams_branches');
            $table->foreign('sub_branch_id')->references('id')->on('itams_sub_branches');
            $table->foreign('department_id')->references('id')->on('itams_departments');
            $table->foreign('jop_title_id')->references('id')->on('itams_jop_titles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itams_employees');
    }
};
