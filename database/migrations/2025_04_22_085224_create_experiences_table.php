<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('image');
            $table->string('company');
            $table->string('location');
            $table->enum('location_type', ['onsite', 'hybrid', 'remote']);
            $table->string('month_start');
            $table->string('month_end');
            $table->integer('year_start');
            $table->integer('year_end');
            $table->text('description');
            $table->string('position');
            $table->enum('employment_type', ['fulltime', 'parttime', 'selfemployed', 'contract', 'internship', 'seasonal']);
            $table->uuid('experience_category_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
