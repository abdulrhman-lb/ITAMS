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
        Schema::create('itams_sub_branches', function (Blueprint $table) {
            $table->id();
            $table->string('sub_branch');
            $table->string('sub_branch_en');
            $table->unsignedBigInteger('branch_id');
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('itams_branches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itams_sub_branches');
    }
};
