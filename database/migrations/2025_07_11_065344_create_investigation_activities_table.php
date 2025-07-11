<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigationActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigation_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investigation_id')->constrained('investigations');
            $table->enum('activity_type', ['document_analysis', 'interview', 'similarity_check', 'metadata_audit']);
            $table->text('description')->nullable();
            $table->date('activity_date')->nullable();
            $table->foreignId('performed_by')->constrained('users');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('investigation_activities');
    }
}
