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
        Schema::create('master_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->text('job_description');
            $table->string('job_experience');
            $table->string('job_salary');
            $table->string('job_location');
            $table->string('job_extra_info')->nullable();
            $table->string('job_company_name');
            $table->string('job_company_logo')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matser_jobs');
    }
};
