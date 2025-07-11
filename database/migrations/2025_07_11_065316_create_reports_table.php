<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('reporter_id')->constrained('users');
            $table->string('reported_person_name');
            $table->string('reported_person_email')->nullable();
            $table->enum('reported_person_type', ['student', 'lecturer', 'staff', 'external']);
            $table->foreignId('violation_type_id')->constrained('violation_types');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('incident_date')->nullable();
            $table->enum('submission_method', ['online', 'offline']);
            $table->enum('status', ['submitted', 'validated', 'under_investigation', 'completed', 'rejected', 'appeal']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
